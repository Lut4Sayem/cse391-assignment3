-- ============================================================
-- Hollywood Car Workshop - Database Setup Script
-- Database: workshop_db
-- ============================================================

CREATE DATABASE IF NOT EXISTS workshop_db;
USE workshop_db;

-- Drop tables if you want a clean reinstall (optional)
-- WARNING: This will delete all existing data.
-- DROP TABLE IF EXISTS appointments;
-- DROP TABLE IF EXISTS mechanics;

-- ----------------------------
-- Mechanics table
-- ----------------------------
CREATE TABLE IF NOT EXISTS mechanics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialty VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

-- Insert initial mechanics (safe approach: only if table is empty)
INSERT INTO mechanics (name, specialty)
SELECT * FROM (
    SELECT 'Walter White', 'Chemical Engine Performance Tuning' UNION ALL
    SELECT 'Dominic Toretto', 'Muscle Car & NOS Specialist' UNION ALL
    SELECT 'John Wick', 'Precision Diagnostics Expert' UNION ALL
    SELECT 'Bruce Wayne', 'Exotic & Armored Vehicle Expert' UNION ALL
    SELECT 'James Bond', 'Gadget-Integrated Vehicle Systems'
) AS tmp
WHERE NOT EXISTS (SELECT 1 FROM mechanics);

-- ----------------------------
-- Appointments table
-- ----------------------------
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    address VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(50) NOT NULL,
    car_license VARCHAR(50) NOT NULL,
    car_engine VARCHAR(50) NOT NULL,
    appointment_date DATE NOT NULL,
    mechanic_id INT NOT NULL,

    CONSTRAINT fk_appointments_mechanic
        FOREIGN KEY (mechanic_id)
        REFERENCES mechanics(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    -- Business Rule 1 (DB-level): no duplicate booking
    UNIQUE KEY uniq_car_license_date (car_license, appointment_date)
) ENGINE=InnoDB;