-- Migration: Create admin_logs table for logging admin activities (MySQL version)
-- Created: 2024-06-09
-- Description: This table stores all admin activities including login, logout, CRUD operations, and errors

CREATE TABLE IF NOT EXISTS admin_logs (
    id INT(11) NOT NULL AUTO_INCREMENT,
    admin_id INT(11) NOT NULL,
    action_type ENUM('LOGIN','LOGOUT','CREATE','READ','UPDATE','DELETE','ERROR') NOT NULL,
    table_name VARCHAR(50) DEFAULT NULL,
    record_id INT(11) DEFAULT NULL,
    old_data JSON DEFAULT NULL,
    new_data JSON DEFAULT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT DEFAULT NULL,
    error_message TEXT DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_admin_logs_admin_id (admin_id),
    KEY idx_admin_logs_action_type (action_type),
    KEY idx_admin_logs_table_name (table_name),
    KEY idx_admin_logs_created_at (created_at),
    KEY idx_admin_logs_admin_action_date (admin_id, action_type, created_at),
    KEY idx_admin_logs_table_record (table_name, record_id),
    CONSTRAINT fk_admin_logs_admin_id FOREIGN KEY (admin_id) REFERENCES admins (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
