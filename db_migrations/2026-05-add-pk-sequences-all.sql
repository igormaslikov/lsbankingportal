-- ============================================================================
-- 2026-05-add-pk-sequences-all.sql
--
-- ONE-SHOT migration: scan every user table in the current database, find
-- single-column integer-like primary keys that have NO IDENTITY and NO
-- DEFAULT, and add a SEQUENCE + DEFAULT NEXT VALUE FOR <seq> on each.
--
-- Why: this schema was migrated from MySQL where PKs were AUTO_INCREMENT.
-- The new SQL Server tables were created without IDENTITY, so INSERTs that
-- omit the PK column fail with:
--   "Cannot insert the value NULL into column 'X', table 'Y'; column does
--   not allow nulls."
--
-- Approach: SEQUENCE + DEFAULT instead of IDENTITY because SQL Server cannot
-- add IDENTITY to an existing column via ALTER COLUMN (would require drop +
-- recreate of the table). SEQUENCE + DEFAULT is one ALTER, preserves all
-- rows and FK relationships, and behaves identically for INSERTs that omit
-- the column.
--
-- Scope:
--   + Only user tables in the dbo schema (skips sys/INFORMATION_SCHEMA).
--   + Only tables with a single-column PRIMARY KEY (skips composite keys).
--   + Only integer-like PK types: int, bigint, smallint, tinyint,
--     numeric/decimal with scale = 0.
--   + Skips PKs that already have IDENTITY.
--   + Skips PKs that already have any DEFAULT constraint.
--   + Skips columns explicitly excluded below (see @exclude).
--
-- Caveat: SCOPE_IDENTITY() / @@IDENTITY do NOT capture values from a
-- sequence DEFAULT. Code that needs the new id must either re-query by a
-- unique business key, or use INSERT ... OUTPUT INSERTED.<col> INTO @tmp.
-- The portal mostly re-queries by user_key / email_key / loan_create_id,
-- so this is rarely an issue.
--
-- Safe to re-run (idempotent). Run against your target database (USE OfscaBank).
-- ============================================================================

SET NOCOUNT ON;
PRINT '=== One-shot PK sequence+default migration ===';
PRINT 'Database: ' + DB_NAME();
PRINT '';

-- ----------------------------------------------------------------------------
-- Excludes: tables/columns to leave alone (e.g. business-generated IDs that
-- look numeric but aren't auto-increment, or PKs already managed elsewhere).
-- Add (table_name, NULL) to skip a whole table, or (table_name, col_name)
-- to skip just one column.
-- ----------------------------------------------------------------------------
DECLARE @exclude TABLE (table_name SYSNAME, col_name SYSNAME NULL);
-- (none for now — uncomment and edit if you find a table that shouldn't auto-PK)
-- INSERT INTO @exclude VALUES ('tbl_lists', NULL);

-- ----------------------------------------------------------------------------
-- Build the work list: every eligible single-column PK that needs the fix.
-- ----------------------------------------------------------------------------
DECLARE @candidates TABLE (
    table_name SYSNAME,
    col_name   SYSNAME,
    type_name  SYSNAME
);

INSERT INTO @candidates (table_name, col_name, type_name)
SELECT
    t.name,
    c.name,
    ty.name
FROM sys.tables t
JOIN sys.schemas s         ON s.schema_id = t.schema_id
JOIN sys.indexes i         ON i.object_id = t.object_id AND i.is_primary_key = 1
JOIN sys.index_columns ic  ON ic.object_id = t.object_id AND ic.index_id = i.index_id
JOIN sys.columns c         ON c.object_id = t.object_id AND c.column_id = ic.column_id
JOIN sys.types ty          ON ty.user_type_id = c.user_type_id
WHERE s.name = 'dbo'
  -- single-column PK only
  AND (SELECT COUNT(*) FROM sys.index_columns ic2 WHERE ic2.object_id = t.object_id AND ic2.index_id = i.index_id) = 1
  -- integer-like type only
  AND (
       ty.name IN ('int','bigint','smallint','tinyint')
       OR (ty.name IN ('numeric','decimal') AND c.scale = 0)
  )
  -- skip if already IDENTITY
  AND NOT EXISTS (
       SELECT 1 FROM sys.identity_columns ic3
       WHERE ic3.object_id = t.object_id AND ic3.column_id = c.column_id
  )
  -- skip if column already has any DEFAULT
  AND c.default_object_id = 0
  -- skip excluded tables/columns
  AND NOT EXISTS (
       SELECT 1 FROM @exclude e
       WHERE e.table_name = t.name AND (e.col_name IS NULL OR e.col_name = c.name)
  );

DECLARE @found INT = (SELECT COUNT(*) FROM @candidates);
PRINT 'Eligible PKs needing SEQUENCE+DEFAULT: ' + CAST(@found AS NVARCHAR(10));
PRINT '';

IF @found = 0
BEGIN
    PRINT 'Nothing to do. All eligible PKs already have IDENTITY or a DEFAULT.';
    RETURN;
END

-- ----------------------------------------------------------------------------
-- Apply: create SEQUENCE + DEFAULT for each candidate.
-- ----------------------------------------------------------------------------
DECLARE @table SYSNAME, @col SYSNAME, @type SYSNAME;
DECLARE @seq SYSNAME, @cons SYSNAME;
DECLARE @sql NVARCHAR(MAX);
DECLARE @start_int BIGINT;
DECLARE @start_str NVARCHAR(20);
DECLARE @applied INT = 0;
DECLARE @skipped INT = 0;

DECLARE cur CURSOR LOCAL FAST_FORWARD FOR
    SELECT table_name, col_name, type_name FROM @candidates ORDER BY table_name;
OPEN cur;
FETCH NEXT FROM cur INTO @table, @col, @type;
WHILE @@FETCH_STATUS = 0
BEGIN
    SET @seq  = 'seq_' + @table + '_' + @col;
    SET @cons = 'DF_'  + @table + '_' + @col;

    -- Read MAX via dynamic SQL (per-table since we can't statically reference @col).
    SET @sql = N'SELECT @s_out = ISNULL(MAX(' + QUOTENAME(@col) + N'), 0) + 1 FROM ' + QUOTENAME(@table);
    BEGIN TRY
        EXEC sp_executesql @sql, N'@s_out BIGINT OUTPUT', @s_out = @start_int OUTPUT;
    END TRY
    BEGIN CATCH
        PRINT '[error] could not read MAX(' + @col + ') from ' + @table + ': ' + ERROR_MESSAGE();
        SET @skipped = @skipped + 1;
        FETCH NEXT FROM cur INTO @table, @col, @type;
        CONTINUE;
    END CATCH
    SET @start_str = CAST(@start_int AS NVARCHAR(20));

    -- Create SEQUENCE (skip if it somehow already exists with this exact name).
    IF NOT EXISTS (SELECT 1 FROM sys.sequences WHERE name = @seq)
    BEGIN
        BEGIN TRY
            SET @sql = N'CREATE SEQUENCE dbo.' + QUOTENAME(@seq)
                     + N' AS ' + (CASE WHEN @type IN ('bigint','numeric','decimal') THEN N'BIGINT' ELSE N'BIGINT' END)
                     + N' START WITH ' + @start_str
                     + N' INCREMENT BY 1 NO CACHE';
            EXEC sp_executesql @sql;
        END TRY
        BEGIN CATCH
            PRINT '[error] CREATE SEQUENCE ' + @seq + ' failed: ' + ERROR_MESSAGE();
            SET @skipped = @skipped + 1;
            FETCH NEXT FROM cur INTO @table, @col, @type;
            CONTINUE;
        END CATCH
    END

    -- Add DEFAULT (idempotent by name).
    IF NOT EXISTS (SELECT 1 FROM sys.default_constraints WHERE name = @cons)
    BEGIN
        BEGIN TRY
            SET @sql = N'ALTER TABLE ' + QUOTENAME(@table)
                     + N' ADD CONSTRAINT ' + QUOTENAME(@cons)
                     + N' DEFAULT NEXT VALUE FOR dbo.' + QUOTENAME(@seq)
                     + N' FOR ' + QUOTENAME(@col);
            EXEC sp_executesql @sql;
            PRINT '[applied] ' + @table + '.' + @col + '  (start=' + @start_str + ')';
            SET @applied = @applied + 1;
        END TRY
        BEGIN CATCH
            PRINT '[error] ALTER TABLE ' + @table + ' ADD DEFAULT failed: ' + ERROR_MESSAGE();
            SET @skipped = @skipped + 1;
        END CATCH
    END
    ELSE
    BEGIN
        PRINT '[skip] DEFAULT ' + @cons + ' already exists on ' + @table + '.' + @col;
        SET @skipped = @skipped + 1;
    END

    FETCH NEXT FROM cur INTO @table, @col, @type;
END
CLOSE cur;
DEALLOCATE cur;

PRINT '';
PRINT '=== Summary ===';
PRINT 'Applied: ' + CAST(@applied AS NVARCHAR(10));
PRINT 'Skipped/errored: ' + CAST(@skipped AS NVARCHAR(10));
PRINT 'Done.';

-- ============================================================================
-- ROLLBACK (manual; lists each SEQUENCE and DEFAULT this script created).
-- Run the SELECT below to generate the DROP statements for the constraints
-- and sequences whose names match our DF_/seq_ prefix pattern:
--
--   SELECT 'ALTER TABLE ' + QUOTENAME(OBJECT_NAME(parent_object_id))
--        + ' DROP CONSTRAINT ' + QUOTENAME(name) + ';'
--   FROM sys.default_constraints WHERE name LIKE 'DF_%';
--
--   SELECT 'DROP SEQUENCE dbo.' + QUOTENAME(name) + ';'
--   FROM sys.sequences WHERE name LIKE 'seq_%';
-- ============================================================================
