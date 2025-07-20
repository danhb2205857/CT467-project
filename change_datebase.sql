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


ALTER TABLE `library_management`.`borrow_slip_details` 
ADD COLUMN `due_date` DATE NULL AFTER `fine_amount`;

ALTER TABLE `library_management`.`readers` 
ADD COLUMN `bookcount` INT NULL DEFAULT NULL AFTER `borrowcount`;

DELIMITER $$
CREATE TRIGGER trg_after_insert_borrow_detail_update_bookcount
AFTER INSERT ON borrow_slip_details
FOR EACH ROW
BEGIN
    DECLARE v_reader_id INT;
    SELECT reader_id INTO v_reader_id FROM borrow_slips WHERE id = NEW.borrow_slip_id;
    UPDATE readers
    SET bookcount = IFNULL(bookcount, 0) + NEW.quantity
    WHERE id = v_reader_id;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER trg_after_insert_borrow_slip_update_borrowcount
AFTER INSERT ON borrow_slips
FOR EACH ROW
BEGIN
    UPDATE readers
    SET borrowcount = IFNULL(borrowcount, 0) + 1
    WHERE id = NEW.reader_id;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_get_borrow_slips_by_status(IN p_status VARCHAR(10))
BEGIN
    SELECT 
        bs.*, 
        r.name as name
    FROM borrow_slips bs
    LEFT JOIN readers r ON bs.reader_id = r.id
    WHERE (p_status = '' OR bs.status = p_status)
    ORDER BY 
        CASE 
            WHEN bs.status = '2' THEN 0
            WHEN bs.status = '0' THEN 1
            WHEN bs.status = '1' THEN 2
            ELSE 3
        END,
        CASE 
            WHEN bs.status = '1' THEN bs.return_date
            ELSE NULL
        END DESC;
END$$
DELIMITER ;