-- Run this file to set up the loginapp database
-- Command: sudo mysql < setup.sql

CREATE DATABASE IF NOT EXISTS loginapp;

USE loginapp;

CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50)  NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional: verify the table was created
SHOW TABLES;
DESCRIBE users;
