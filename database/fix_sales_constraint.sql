-- Fix for sales table foreign key constraint
-- This removes the foreign key constraint on Payment_ID so we can store Design_ID there
-- Run this in phpMyAdmin or MySQL console

USE graphio_dbv2;

-- Drop the foreign key constraint on Payment_ID
ALTER TABLE `sales` DROP FOREIGN KEY `sales_ibfk_1`;

-- Optional: Add a Design_ID column if you want to keep both Payment_ID and Design_ID separate
-- ALTER TABLE `sales` ADD COLUMN `Design_ID` int(11) NULL AFTER `Payment_ID`;
-- ALTER TABLE `sales` ADD KEY `Design_ID` (`Design_ID`);

-- Verify the change
SHOW CREATE TABLE `sales`;
