-- ============================================================================
-- 2026-05-add-pk-sequences-commercial.sql  (v2 - dynamic SQL, parse-safe)
--
-- Add SEQUENCE+DEFAULT to commercial-loan-flow PK columns that were
-- MySQL AUTO_INCREMENT and lack IDENTITY/DEFAULT on this SQL Server schema.
--
-- v2 changes:
--   - All column references go through sp_executesql so a missing column
--     doesn't kill the whole batch at parse time.
--   - Skip-with-PRINT when the expected column doesn't exist (so we can
--     see which tables still need attention).
--   - Discovery query at top lists the actual PK column for each table so
--     you can confirm names before running the apply blocks below.
--
-- Idempotent. Safe to re-run.
-- ============================================================================

SET NOCOUNT ON;

-- ============================================================================
-- DISCOVERY: show actual PK column per table.
-- Inspect this output BEFORE running the apply blocks below. If a row here
-- shows a column name that doesn't match what the apply block expects,
-- update the @col_name value in that block.
-- ============================================================================
PRINT '=== Discovery: actual PK column per table ===';
SELECT
    t.name        AS table_name,
    c.name        AS pk_column,
    ty.name       AS data_type,
    c.is_nullable AS nullable,
    c.is_identity AS is_identity,
    dc.name       AS default_constraint
FROM sys.tables t
JOIN sys.indexes i           ON i.object_id = t.object_id AND i.is_primary_key = 1
JOIN sys.index_columns ic    ON ic.object_id = t.object_id AND ic.index_id = i.index_id
JOIN sys.columns c           ON c.object_id = t.object_id AND c.column_id = ic.column_id
JOIN sys.types ty            ON ty.user_type_id = c.user_type_id
LEFT JOIN sys.default_constraints dc ON dc.parent_object_id = t.object_id AND dc.parent_column_id = c.column_id
WHERE t.name IN (
    'commercial_loan_initial_banking',
    'tbl_commercial_loan',
    'tbl_other_fees',
    'tbl_bank_info',
    'tbl_bank_cards',
    'tbl_lists'
)
ORDER BY t.name;
PRINT '=== End discovery ===';

-- ============================================================================
-- APPLY: generic helper inlined as dynamic-SQL block per (table, column).
-- Each block:
--   1. Checks the column exists (sys.columns)
--   2. Checks the column has no IDENTITY and no DEFAULT already
--   3. Creates the SEQUENCE starting at MAX(col)+1
--   4. Adds the DEFAULT constraint
-- All column references are inside sp_executesql so a missing column won't
-- kill the batch.
-- ============================================================================

DECLARE @table SYSNAME, @col SYSNAME, @seq SYSNAME, @cons SYSNAME, @sql NVARCHAR(MAX), @start_str NVARCHAR(20);

-- Each row below = one (table, column) to fix. If discovery shows a
-- different PK column for a table, edit the second value in that row.
DECLARE @work TABLE (table_name SYSNAME, col_name SYSNAME);
INSERT INTO @work VALUES
    ('commercial_loan_initial_banking', 'id'),       -- discovery may show another name
    ('tbl_commercial_loan',             'loan_id'),
    ('tbl_other_fees',                  'tbl_other_fees_id'),
    ('tbl_bank_info',                   'bank_id'),
    ('tbl_bank_cards',                  'id'),       -- discovery may show another name
    ('tbl_lists',                       'tbl_lists_id');

DECLARE cur CURSOR LOCAL FAST_FORWARD FOR SELECT table_name, col_name FROM @work;
OPEN cur;
FETCH NEXT FROM cur INTO @table, @col;
WHILE @@FETCH_STATUS = 0
BEGIN
    -- 1. Table exists?
    IF OBJECT_ID('dbo.' + QUOTENAME(@table), 'U') IS NULL
    BEGIN
        PRINT '[skip] table ' + @table + ' does not exist.';
        FETCH NEXT FROM cur INTO @table, @col;
        CONTINUE;
    END

    -- 2. Column exists on this table?
    IF NOT EXISTS (
        SELECT 1 FROM sys.columns
        WHERE object_id = OBJECT_ID('dbo.' + QUOTENAME(@table)) AND name = @col
    )
    BEGIN
        PRINT '[skip] ' + @table + '.' + @col + ' does not exist; check Discovery output above for the real PK column name.';
        FETCH NEXT FROM cur INTO @table, @col;
        CONTINUE;
    END

    -- 3. Already IDENTITY?
    IF EXISTS (
        SELECT 1 FROM sys.identity_columns
        WHERE object_id = OBJECT_ID('dbo.' + QUOTENAME(@table)) AND name = @col
    )
    BEGIN
        PRINT '[skip] ' + @table + '.' + @col + ' is already IDENTITY.';
        FETCH NEXT FROM cur INTO @table, @col;
        CONTINUE;
    END

    -- 4. Already has DEFAULT?
    IF EXISTS (
        SELECT 1 FROM sys.default_constraints dc
        JOIN sys.columns c ON c.default_object_id = dc.object_id
        WHERE c.object_id = OBJECT_ID('dbo.' + QUOTENAME(@table)) AND c.name = @col
    )
    BEGIN
        PRINT '[skip] ' + @table + '.' + @col + ' already has a DEFAULT.';
        FETCH NEXT FROM cur INTO @table, @col;
        CONTINUE;
    END

    SET @seq  = 'seq_' + @table + '_' + @col;
    SET @cons = 'DF_'  + @table + '_' + @col;

    -- 5. Read MAX(col) via dynamic SQL (so parser is happy even if col is missing)
    DECLARE @start_int BIGINT;
    SET @sql = N'SELECT @s_out = ISNULL(MAX(' + QUOTENAME(@col) + N'), 0) + 1 FROM ' + QUOTENAME(@table);
    EXEC sp_executesql @sql, N'@s_out BIGINT OUTPUT', @s_out = @start_int OUTPUT;
    SET @start_str = CAST(@start_int AS NVARCHAR(20));

    -- 6. Create SEQUENCE
    IF NOT EXISTS (SELECT 1 FROM sys.sequences WHERE name = @seq)
    BEGIN
        SET @sql = N'CREATE SEQUENCE dbo.' + QUOTENAME(@seq) + N' AS BIGINT START WITH ' + @start_str + N' INCREMENT BY 1 NO CACHE';
        EXEC sp_executesql @sql;
        PRINT 'Created ' + @seq + ' starting at ' + @start_str;
    END

    -- 7. Add DEFAULT constraint
    SET @sql = N'ALTER TABLE ' + QUOTENAME(@table)
             + N' ADD CONSTRAINT ' + QUOTENAME(@cons)
             + N' DEFAULT NEXT VALUE FOR dbo.' + QUOTENAME(@seq)
             + N' FOR ' + QUOTENAME(@col);
    EXEC sp_executesql @sql;
    PRINT 'Added ' + @cons + ' on ' + @table + '.' + @col;

    FETCH NEXT FROM cur INTO @table, @col;
END
CLOSE cur;
DEALLOCATE cur;

PRINT '=== Migration complete ===';

-- ============================================================================
-- ROLLBACK (manual; edit if column names differ from defaults above)
-- ============================================================================
-- ALTER TABLE commercial_loan_initial_banking DROP CONSTRAINT DF_commercial_loan_initial_banking_id;
-- ALTER TABLE tbl_commercial_loan             DROP CONSTRAINT DF_tbl_commercial_loan_loan_id;
-- ALTER TABLE tbl_other_fees                  DROP CONSTRAINT DF_tbl_other_fees_tbl_other_fees_id;
-- ALTER TABLE tbl_bank_info                   DROP CONSTRAINT DF_tbl_bank_info_bank_id;
-- ALTER TABLE tbl_bank_cards                  DROP CONSTRAINT DF_tbl_bank_cards_id;
-- ALTER TABLE tbl_lists                       DROP CONSTRAINT DF_tbl_lists_tbl_lists_id;
-- DROP SEQUENCE dbo.seq_commercial_loan_initial_banking_id;
-- DROP SEQUENCE dbo.seq_tbl_commercial_loan_loan_id;
-- DROP SEQUENCE dbo.seq_tbl_other_fees_tbl_other_fees_id;
-- DROP SEQUENCE dbo.seq_tbl_bank_info_bank_id;
-- DROP SEQUENCE dbo.seq_tbl_bank_cards_id;
-- DROP SEQUENCE dbo.seq_tbl_lists_tbl_lists_id;
