-- =========================================================
-- SMART CAMPUS ROOM RESERVATION SYSTEM (MILESTONE 2)
-- =========================================================

CREATE DATABASE IF NOT EXISTS room_reservation_system;
USE room_reservation_system;

-- Disable checks temporarily to drop tables without errors
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS approval;
DROP TABLE IF EXISTS reservation_resource;
DROP TABLE IF EXISTS reservation;
DROP TABLE IF EXISTS resource;
DROP TABLE IF EXISTS room;
DROP TABLE IF EXISTS approval_authority;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS user_role;
DROP TABLE IF EXISTS room_category;
DROP TABLE IF EXISTS resource_category;

SET FOREIGN_KEY_CHECKS = 1;

-- =========================
-- 1) USER ROLE (DDL)
-- =========================
CREATE TABLE user_role (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 2) USERS (DDL)
-- =========================
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    department VARCHAR(100),
    role_id INT NOT NULL,
    CONSTRAINT fk_users_role
        FOREIGN KEY (role_id) REFERENCES user_role(role_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 3) ROOM CATEGORY (DDL)
-- =========================
CREATE TABLE room_category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 4) ROOM (DDL)
-- =========================
CREATE TABLE room (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    room_name VARCHAR(100) NOT NULL,
    building VARCHAR(100) NOT NULL,
    floor INT NOT NULL,
    room_number VARCHAR(20) NOT NULL,
    capacity INT,
    status VARCHAR(50),
    CONSTRAINT fk_room_category
        FOREIGN KEY (category_id) REFERENCES room_category(category_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 5) RESOURCE CATEGORY (DDL)
-- =========================
CREATE TABLE resource_category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 6) RESOURCE (DDL)
-- =========================
CREATE TABLE resource (
    resource_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    room_id INT NOT NULL,
    resource_name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    status VARCHAR(50),
    CONSTRAINT fk_resource_category
        FOREIGN KEY (category_id) REFERENCES resource_category(category_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_resource_room
        FOREIGN KEY (room_id) REFERENCES room(room_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 7) RESERVATION (DDL)
-- =========================
CREATE TABLE reservation (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    reservation_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    purpose VARCHAR(255),
    status VARCHAR(50),
day_of_week VARCHAR(15),
    duration INT
        GENERATED ALWAYS AS (
            TIMESTAMPDIFF(
                MINUTE,
                TIMESTAMP(reservation_date, start_time),
                TIMESTAMP(reservation_date, end_time)
            )
        ) STORED,
    CONSTRAINT fk_reservation_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_reservation_room
        FOREIGN KEY (room_id) REFERENCES room(room_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 8) RESERVATION_RESOURCE (DDL)
-- =========================
CREATE TABLE reservation_resource (
    reservation_id INT NOT NULL,
    resource_id INT NOT NULL,
    quantity_used INT NOT NULL DEFAULT 0,
    PRIMARY KEY (reservation_id, resource_id),
    CONSTRAINT fk_rr_reservation
        FOREIGN KEY (reservation_id) REFERENCES reservation(reservation_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_rr_resource
        FOREIGN KEY (resource_id) REFERENCES resource(resource_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 9) APPROVAL (DDL)
-- =========================
CREATE TABLE approval (
    approval_id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    approver_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    approval_date DATE,
    approval_time TIME,
    remarks TEXT,
    CONSTRAINT fk_approval_reservation
        FOREIGN KEY (reservation_id) REFERENCES reservation(reservation_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_approval_user
        FOREIGN KEY (approver_id) REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 10) APPROVAL AUTHORITY (DDL)
-- =========================
CREATE TABLE approval_authority (
    authority_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    role_id INT NOT NULL,
    CONSTRAINT fk_authority_category
        FOREIGN KEY (category_id) REFERENCES room_category(category_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_authority_role
        FOREIGN KEY (role_id) REFERENCES user_role(role_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    UNIQUE KEY uq_authority_category_role (category_id, role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 11) NOTIFICATION (DDL)
-- =========================
CREATE TABLE notification (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    date_sent DATE NOT NULL,
    time_sent TIME NOT NULL,
    status VARCHAR(50),
    CONSTRAINT fk_notification_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- =========================================================================
-- DML: SAMPLE DATA INSERTION (FOR MILESTONE 2 "Exceptional" Rubric)
-- =========================================================================

-- 1. Insert User Roles
INSERT INTO user_role (role_name) VALUES 
('Admin'), 
('Faculty'), 
('Student');

-- 2. Insert Room Categories
INSERT INTO room_category (category_name) VALUES 
('Lecture Room'), 
('Laboratory'), 
('Conference Room');

-- 3. Insert Sample Users (role_id: 1=Admin, 2=Faculty, 3=Student)
INSERT INTO users (first_name, last_name, email, phone_number, password, department, role_id) VALUES 
('Rob', 'Malitao', 'rmalitao@campus.edu', '09123456789', 'admin123', 'IT Department', 1),
('Aahron Jamez', 'Garcia', 'agarcia@student.edu', '09987654321', 'student123', 'Computer Science', 3),
('Hoby Ace Jerico', 'Josol', 'hjosol@student.edu', '09112223333', 'student123', 'Computer Science', 3),
('Matthew', 'Lopez', 'mlopez@student.edu', '09445556666', 'student123', 'Information Systems', 3),
('Lyncoln', 'Perez', 'lperez@student.edu', '09778889999', 'student123', 'Computer Science', 3),
('John Miko', 'Sarsalijo', 'jsarsalijo@student.edu', '09887776666', 'student123', 'Computer Science', 3);

-- 4. Insert Sample Rooms (category_id: 1=Lecture, 2=Lab, 3=Conference)
INSERT INTO room (category_id, room_name, building, floor, room_number, capacity, status) VALUES 
(1, 'Main Auditorium', 'Main Building', 1, '100A', 150, 'Available'),
(2, 'Mac Lab A', 'IT Building', 2, '201A', 35, 'Available'),
(2, 'Cisco Networking Lab', 'IT Building', 2, '202B', 40, 'Available'),
(3, 'Faculty Meeting Room', 'IT Building', 3, '305C', 12, 'Available'),
(1, 'Lecture Hall C', 'Science Building', 1, '104', 50, 'Maintenance');

-- 5. Insert Sample Reservations
INSERT INTO reservation (user_id, room_id, reservation_date, start_time, end_time, purpose, status) VALUES 
(2, 2, '2026-04-25', '10:00:00', '12:00:00', 'Academic Ledger Group Project Coding', 'Approved'),
(3, 3, '2026-04-26', '14:00:00', '16:00:00', 'Database Networking Setup', 'Pending'),
(1, 4, '2026-04-28', '09:00:00', '11:00:00', 'Faculty Alignment Meeting', 'Approved');
