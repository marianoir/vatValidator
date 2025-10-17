CREATE DATABASE vat_validator;
USE vat_validator;

CREATE TABLE vat_numbers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id VARCHAR(50) NOT NULL,
    vat_number VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);