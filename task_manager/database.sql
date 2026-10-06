-- =====================================================
-- Student Task Manager - Database export
-- Import this file in phpMyAdmin (Import tab) to
-- create the database, the tasks table, and sample rows.
-- =====================================================

-- Create the database if it does not exist yet
CREATE DATABASE IF NOT EXISTS task_manager;

-- Select this database so the next commands run in it
USE task_manager;

-- Create the tasks table with the exact columns we need
CREATE TABLE IF NOT EXISTS tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    priority VARCHAR(20),
    due_date DATE,
    completed TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

