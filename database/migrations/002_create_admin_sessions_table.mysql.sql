-- Migration: Create admin_sessions table for tracking admin login sessions (MySQL version)
-- Created: 2024-06-09
-- Description: This table tracks admin login sessions, including login/logout times and session management

CREATE TABLE IF NOT EXISTS admin_sessions (
    id INT(11) NOT NULL AUTO_INCREMENT,
    admin_id INT(11) NOT NULL,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    login_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    logout_time TIMESTAMP NULL DEFAULT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT DEFAULT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    last_activity TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY idx_admin_sessions_token (session_token),
    KEY idx_admin_sessions_admin_id (admin_id),
    KEY idx_admin_sessions_is_active (is_active),
    KEY idx_admin_sessions_login_time (login_time),
    KEY idx_admin_sessions_admin_active (admin_id, is_active),
    KEY idx_admin_sessions_last_activity (last_activity),
    CONSTRAINT fk_admin_sessions_admin_id FOREIGN KEY (admin_id) REFERENCES admins (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
