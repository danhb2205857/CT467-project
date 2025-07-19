ALTER TABLE `library_management`.`borrow_slips` 
CHANGE COLUMN `borrow_date` `borrow_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `library_management`.`readers` 
DROP COLUMN `birth_date`,
ADD COLUMN `borrowcount` INT NULL AFTER `updated_at`;

ALTER TABLE `library_management`.`borrow_slips` 
ADD COLUMN `phone` VARCHAR(15) NOT NULL AFTER `updated_at`;

ALTER TABLE `library_management`.`readers` 
CHANGE COLUMN `borrowcount` `borrowcount` INT NULL DEFAULT 0 ;

ALTER TABLE `library_management`.`borrow_slips` 
ADD COLUMN `due_dated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `phone`;

ALTER TABLE `library_management`.`borrow_slips` 
CHANGE COLUMN `due_dated` `return_date` TIMESTAMP NULL ;


ALTER TABLE `library_management`.`borrow_slips` 
CHANGE COLUMN `status` `status` ENUM('0', '1', '2') CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_ci' NOT NULL DEFAULT '0' ;
