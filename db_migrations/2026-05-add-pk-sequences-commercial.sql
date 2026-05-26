-- ============================================================================
-- 2026-05-add-pk-sequences-commercial.sql
--
-- Same approach as 2026-05-add-pk-sequences-fnd.sql: add SEQUENCE+DEFAULT
-- to auto-fill primary-key columns that were originally MySQL AUTO_INCREMENT
-- but lack IDENTITY / DEFAULT on this SQL Server schema.
--
-- Tables covered (commercial-loan flow):
--   commercial_loan_initial_banking.id
--   tbl_commercial_loan.loan_id
--   tbl_other_fees.tbl_other_fees_id
--   tbl_bank_info.bank_id
--   tbl_bank_cards.id
--   tbl_lists.tbl_lists_id
--
-- Idempotent (safe to re-run).
-- ============================================================================

SET NOCOUNT ON;

DECLARE @start BIGINT;
DECLARE @sql NVARCHAR(MAX);

-- ----------------------------------------------------------------------------
-- Helper macro inlined per-table (T-SQL has no macros) using IF NOT EXISTS
-- guards on both the SEQUENCE and the DEFAULT CONSTRAINT.
-- ----------------------------------------------------------------------------

-- commercial_loan_initial_banking.id
IF OBJECT_ID('dbo.commercial_loan_initial_banking', 'U') IS NOT NULL
AND EXISTS (SELECT 1 FROM sys.columns WHERE object_id = OBJECT_ID('dbo.commercial_loan_initial_banking') AND name = 'id')
BEGIN
    IF NOT EXISTS (SELECT 1 FROM sys.sequences WHERE name = 'seq_commercial_loan_initial_banking_id')
    BEGIN
        SELECT @start = ISNULL(MAX(id), 0) + 1 FROM commercial_loan_initial_banking;
        SET @sql = N'CREATE SEQUENCE dbo.seq_commercial_loan_initial_banking_id AS BIGINT START WITH '
                 + CAST(@start AS NVARCHAR(20)) + N' INCREMENT BY 1 NO CACHE';
        EXEC sp_executesql @sql;
        PRINT 'Created seq_commercial_loan_initial_banking_id starting at ' + CAST(@start AS NVARCHAR(20));
    END
    IF NOT EXISTS (SELECT 1 FROM sys.default_constraints WHERE name = 'DF_commercial_loan_initial_banking_id')
    BEGIN
        ALTER TABLE commercial_loan_initial_banking
            ADD CONSTRAINT DF_commercial_loan_initial_banking_id
            DEFAULT NEXT VALUE FOR dbo.seq_commercial_loan_initial_banking_id FOR id;
        PRINT 'Added DF_commercial_loan_initial_banking_id.';
    END
END

-- tbl_commercial_loan.loan_id
IF OBJECT_ID('dbo.tbl_commercial_loan', 'U') IS NOT NULL
AND EXISTS (SELECT 1 FROM sys.columns WHERE object_id = OBJECT_ID('dbo.tbl_commercial_loan') AND name = 'loan_id')
BEGIN
    IF NOT EXISTS (SELECT 1 FROM sys.sequences WHERE name = 'seq_tbl_commercial_loan_id')
    BEGIN
        SELECT @start = ISNULL(MAX(loan_id), 0) + 1 FROM tbl_commercial_loan;
        SET @sql = N'CREATE SEQUENCE dbo.seq_tbl_commercial_loan_id AS BIGINT START WITH '
                 + CAST(@start AS NVARCHAR(20)) + N' INCREMENT BY 1 NO CACHE';
        EXEC sp_executesql @sql;
        PRINT 'Created seq_tbl_commercial_loan_id starting at ' + CAST(@start AS NVARCHAR(20));
    END
    IF NOT EXISTS (SELECT 1 FROM sys.default_constraints WHERE name = 'DF_tbl_commercial_loan_loan_id')
    BEGIN
        ALTER TABLE tbl_commercial_loan
            ADD CONSTRAINT DF_tbl_commercial_loan_loan_id
            DEFAULT NEXT VALUE FOR dbo.seq_tbl_commercial_loan_id FOR loan_id;
        PRINT 'Added DF_tbl_commercial_loan_loan_id.';
    END
END

-- tbl_other_fees.tbl_other_fees_id
IF OBJECT_ID('dbo.tbl_other_fees', 'U') IS NOT NULL
AND EXISTS (SELECT 1 FROM sys.columns WHERE object_id = OBJECT_ID('dbo.tbl_other_fees') AND name = 'tbl_other_fees_id')
BEGIN
    IF NOT EXISTS (SELECT 1 FROM sys.sequences WHERE name = 'seq_tbl_other_fees_id')
    BEGIN
        SELECT @start = ISNULL(MAX(tbl_other_fees_id), 0) + 1 FROM tbl_other_fees;
        SET @sql = N'CREATE SEQUENCE dbo.seq_tbl_other_fees_id AS BIGINT START WITH '
                 + CAST(@start AS NVARCHAR(20)) + N' INCREMENT BY 1 NO CACHE';
        EXEC sp_executesql @sql;
        PRINT 'Created seq_tbl_other_fees_id starting at ' + CAST(@start AS NVARCHAR(20));
    END
    IF NOT EXISTS (SELECT 1 FROM sys.default_constraints WHERE name = 'DF_tbl_other_fees_id')
    BEGIN
        ALTER TABLE tbl_other_fees
            ADD CONSTRAINT DF_tbl_other_fees_id
            DEFAULT NEXT VALUE FOR dbo.seq_tbl_other_fees_id FOR tbl_other_fees_id;
        PRINT 'Added DF_tbl_other_fees_id.';
    END
END

-- tbl_bank_info.bank_id
IF OBJECT_ID('dbo.tbl_bank_info', 'U') IS NOT NULL
AND EXISTS (SELECT 1 FROM sys.columns WHERE object_id = OBJECT_ID('dbo.tbl_bank_info') AND name = 'bank_id')
BEGIN
    IF NOT EXISTS (SELECT 1 FROM sys.sequences WHERE name = 'seq_tbl_bank_info_id')
    BEGIN
        SELECT @start = ISNULL(MAX(bank_id), 0) + 1 FROM tbl_bank_info;
        SET @sql = N'CREATE SEQUENCE dbo.seq_tbl_bank_info_id AS BIGINT START WITH '
                 + CAST(@start AS NVARCHAR(20)) + N' INCREMENT BY 1 NO CACHE';
        EXEC sp_executesql @sql;
        PRINT 'Created seq_tbl_bank_info_id starting at ' + CAST(@start AS NVARCHAR(20));
    END
    IF NOT EXISTS (SELECT 1 FROM sys.default_constraints WHERE name = 'DF_tbl_bank_info_bank_id')
    BEGIN
        ALTER TABLE tbl_bank_info
            ADD CONSTRAINT DF_tbl_bank_info_bank_id
            DEFAULT NEXT VALUE FOR dbo.seq_tbl_bank_info_id FOR bank_id;
        PRINT 'Added DF_tbl_bank_info_bank_id.';
    END
END

-- tbl_bank_cards.id
IF OBJECT_ID('dbo.tbl_bank_cards', 'U') IS NOT NULL
AND EXISTS (SELECT 1 FROM sys.columns WHERE object_id = OBJECT_ID('dbo.tbl_bank_cards') AND name = 'id')
BEGIN
    IF NOT EXISTS (SELECT 1 FROM sys.sequences WHERE name = 'seq_tbl_bank_cards_id')
    BEGIN
        SELECT @start = ISNULL(MAX(id), 0) + 1 FROM tbl_bank_cards;
        SET @sql = N'CREATE SEQUENCE dbo.seq_tbl_bank_cards_id AS BIGINT START WITH '
                 + CAST(@start AS NVARCHAR(20)) + N' INCREMENT BY 1 NO CACHE';
        EXEC sp_executesql @sql;
        PRINT 'Created seq_tbl_bank_cards_id starting at ' + CAST(@start AS NVARCHAR(20));
    END
    IF NOT EXISTS (SELECT 1 FROM sys.default_constraints WHERE name = 'DF_tbl_bank_cards_id')
    BEGIN
        ALTER TABLE tbl_bank_cards
            ADD CONSTRAINT DF_tbl_bank_cards_id
            DEFAULT NEXT VALUE FOR dbo.seq_tbl_bank_cards_id FOR id;
        PRINT 'Added DF_tbl_bank_cards_id.';
    END
END

-- tbl_lists.tbl_lists_id
IF OBJECT_ID('dbo.tbl_lists', 'U') IS NOT NULL
AND EXISTS (SELECT 1 FROM sys.columns WHERE object_id = OBJECT_ID('dbo.tbl_lists') AND name = 'tbl_lists_id')
BEGIN
    IF NOT EXISTS (SELECT 1 FROM sys.sequences WHERE name = 'seq_tbl_lists_id')
    BEGIN
        SELECT @start = ISNULL(MAX(tbl_lists_id), 0) + 1 FROM tbl_lists;
        SET @sql = N'CREATE SEQUENCE dbo.seq_tbl_lists_id AS BIGINT START WITH '
                 + CAST(@start AS NVARCHAR(20)) + N' INCREMENT BY 1 NO CACHE';
        EXEC sp_executesql @sql;
        PRINT 'Created seq_tbl_lists_id starting at ' + CAST(@start AS NVARCHAR(20));
    END
    IF NOT EXISTS (SELECT 1 FROM sys.default_constraints WHERE name = 'DF_tbl_lists_id')
    BEGIN
        ALTER TABLE tbl_lists
            ADD CONSTRAINT DF_tbl_lists_id
            DEFAULT NEXT VALUE FOR dbo.seq_tbl_lists_id FOR tbl_lists_id;
        PRINT 'Added DF_tbl_lists_id.';
    END
END

PRINT 'Commercial-loan PK migration complete.';

-- ============================================================================
-- ROLLBACK
-- ============================================================================
-- ALTER TABLE commercial_loan_initial_banking DROP CONSTRAINT DF_commercial_loan_initial_banking_id;
-- ALTER TABLE tbl_commercial_loan             DROP CONSTRAINT DF_tbl_commercial_loan_loan_id;
-- ALTER TABLE tbl_other_fees                  DROP CONSTRAINT DF_tbl_other_fees_id;
-- ALTER TABLE tbl_bank_info                   DROP CONSTRAINT DF_tbl_bank_info_bank_id;
-- ALTER TABLE tbl_bank_cards                  DROP CONSTRAINT DF_tbl_bank_cards_id;
-- ALTER TABLE tbl_lists                       DROP CONSTRAINT DF_tbl_lists_id;
-- DROP SEQUENCE dbo.seq_commercial_loan_initial_banking_id;
-- DROP SEQUENCE dbo.seq_tbl_commercial_loan_id;
-- DROP SEQUENCE dbo.seq_tbl_other_fees_id;
-- DROP SEQUENCE dbo.seq_tbl_bank_info_id;
-- DROP SEQUENCE dbo.seq_tbl_bank_cards_id;
-- DROP SEQUENCE dbo.seq_tbl_lists_id;
