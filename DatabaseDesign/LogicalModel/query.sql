-- Show all tables
SELECT name FROM sqlite_master WHERE type='table';

-- Show structure of each table
SELECT sql FROM sqlite_master WHERE type='table';
