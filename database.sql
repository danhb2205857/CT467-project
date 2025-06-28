CREATE DATABASE IF NOT EXISTS library_management DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library_management;

CREATE TABLE admins (
  id int(11) NOT NULL AUTO_INCREMENT,
  email varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  password varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE authors (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE readers (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  birth_date date DEFAULT NULL,
  phone varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE books (
  id int(11) NOT NULL AUTO_INCREMENT,
  author_id int(11) NOT NULL,
  category_id int(11) NOT NULL,
  title varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  publish_year int(11) DEFAULT NULL,
  publisher varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  quantity int(11) NOT NULL DEFAULT 0,
  available int(11) NOT NULL DEFAULT 0,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY author_id (author_id),
  KEY category_id (category_id),
  CONSTRAINT books_ibfk_1 FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE,
  CONSTRAINT books_ibfk_2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE borrow_slips (
  id int(11) NOT NULL AUTO_INCREMENT,
  reader_id int(11) NOT NULL,
  borrow_date date NOT NULL,
  due_date date NOT NULL,
  status enum('Đang mượn','Đã trả','Quá hạn') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Đang mượn',
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY reader_id (reader_id),
  CONSTRAINT borrow_slips_ibfk_1 FOREIGN KEY (reader_id) REFERENCES readers (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE borrow_slip_details (
  id int(11) NOT NULL AUTO_INCREMENT,
  borrow_slip_id int(11) NOT NULL,
  book_id int(11) NOT NULL,
  quantity int(11) NOT NULL,
  return_date date DEFAULT NULL,
  fine_amount decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (id),
  KEY borrow_slip_id (borrow_slip_id),
  KEY book_id (book_id),
  CONSTRAINT borrow_slip_details_ibfk_1 FOREIGN KEY (borrow_slip_id) REFERENCES borrow_slips (id) ON DELETE CASCADE,
  CONSTRAINT borrow_slip_details_ibfk_2 FOREIGN KEY (book_id) REFERENCES books (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELIMITER $$
CREATE FUNCTION fn_check_book_availability(p_book_id INT) 
RETURNS int(11)
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE available_count INT DEFAULT 0;
    SELECT available INTO available_count 
    FROM books 
    WHERE id = p_book_id;
    RETURN IFNULL(available_count, 0);
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER trg_after_insert_borrow_detail 
AFTER INSERT ON borrow_slip_details 
FOR EACH ROW
BEGIN
    UPDATE books 
    SET available = available - NEW.quantity 
    WHERE id = NEW.book_id;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER trg_after_update_borrow_detail 
AFTER UPDATE ON borrow_slip_details 
FOR EACH ROW
BEGIN
    DECLARE v_due_date DATE;
    DECLARE v_fine_days INT DEFAULT 0;
    
    IF NEW.return_date IS NOT NULL AND OLD.return_date IS NULL THEN
        UPDATE books 
        SET available = available + OLD.quantity 
        WHERE id = OLD.book_id;
        
        SELECT due_date INTO v_due_date 
        FROM borrow_slips 
        WHERE id = NEW.borrow_slip_id;
        
        IF NEW.return_date > v_due_date THEN
            SET v_fine_days = DATEDIFF(NEW.return_date, v_due_date);
            UPDATE borrow_slip_details 
            SET fine_amount = v_fine_days * 5000 
            WHERE id = NEW.id;
        END IF;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_get_overdue_borrows()
READS SQL DATA
BEGIN
    SELECT 
        bs.id,
        r.name as reader_name,
        bs.borrow_date,
        bs.due_date,
        DATEDIFF(CURDATE(), bs.due_date) as overdue_days
    FROM borrow_slips bs
    JOIN readers r ON bs.reader_id = r.id
    WHERE bs.status = 'Đang mượn' AND bs.due_date < CURDATE()
    ORDER BY bs.due_date ASC;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_get_monthly_borrow_stats(IN p_year INT, IN p_month INT)
READS SQL DATA
BEGIN
    SELECT 
        b.title,
        a.name as author_name,
        c.name as category_name,
        SUM(bsd.quantity) as total_borrowed
    FROM borrow_slip_details bsd
    JOIN borrow_slips bs ON bsd.borrow_slip_id = bs.id
    JOIN books b ON bsd.book_id = b.id
    JOIN authors a ON b.author_id = a.id
    JOIN categories c ON b.category_id = c.id
    WHERE YEAR(bs.borrow_date) = p_year AND MONTH(bs.borrow_date) = p_month
    GROUP BY b.id, b.title, a.name, c.name
    ORDER BY total_borrowed DESC;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_update_overdue_status()
MODIFIES SQL DATA
BEGIN
    UPDATE borrow_slips 
    SET status = 'Quá hạn' 
    WHERE status = 'Đang mượn' 
    AND due_date < CURDATE();
    
    SELECT ROW_COUNT() as updated_records;
END$$
DELIMITER ;