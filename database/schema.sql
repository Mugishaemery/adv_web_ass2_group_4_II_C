-- ============================================
-- UMUGANDA SMART SERVICE REQUEST PLATFORM
-- Complete Database Schema
-- ============================================

-- Create database
CREATE DATABASE IF NOT EXISTS umuganda;
USE umuganda;

-- 1. REQUESTS TABLE

CREATE TABLE IF NOT EXISTS requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket VARCHAR(50) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(50),
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255),
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    status ENUM('pending', 'in_progress', 'resolved', 'cancelled') DEFAULT 'pending',
    assigned_to INT NULL,
    notes TEXT,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    resolved_at DATETIME NULL,
    INDEX idx_ticket (ticket),
    INDEX idx_status (status),
    INDEX idx_priority (priority)
);

-- 2. REQUEST HISTORY TABLE (Audit Trail)

CREATE TABLE IF NOT EXISTS request_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    old_status VARCHAR(50),
    new_status VARCHAR(50),
    changed_by VARCHAR(100),
    notes TEXT,
    changed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE,
    INDEX idx_request (request_id)
);


-- 3. CATEGORIES TABLE

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    icon VARCHAR(50),
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE
);

-- ============================================
-- 4. USERS TABLE (Admins & Officers)
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'officer') DEFAULT 'officer',
    email VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 5. INSERT CATEGORIES
-- ============================================
INSERT INTO categories (name, icon, description) VALUES
('Water & Sanitation', 'fa-tint', 'Broken water points, pipes, drainage'),
('Street Lighting', 'fa-lightbulb', 'Faulty or missing street lights'),
('Cleaning & Waste', 'fa-trash', 'Garbage collection and cleaning'),
('ICT & Lab Support', 'fa-desktop', 'Computer lab, network issues'),
('Accommodation', 'fa-home', 'Student housing and facilities'),
('Event Support', 'fa-calendar-alt', 'Logistics for community events'),
('Road & Infrastructure', 'fa-road', 'Potholes, pavements, infrastructure'),
('Other', 'fa-question-circle', 'Any other service request');

-- ============================================
-- 6. INSERT USERS WITH HASHED PASSWORDS
-- Password 'admin' = $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
-- Password 'officer' = same hash for demo
-- ============================================
INSERT INTO users (username, password, full_name, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin'),
('officer', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Service Officer', 'officer');

-- ============================================
-- 7. INSERT SAMPLE REQUESTS
-- ============================================
INSERT INTO requests (ticket, full_name, email, phone, category_id, title, description, location, priority, status, notes, submitted_at, resolved_at) VALUES
('UMG-2026-0001', 'Uwimana Alice', 'alice@example.com', '+250788000001', 1, 'Broken water tap at Block C', 'The water tap near Block C dormitory has been leaking for 3 days causing flooding near the entrance.', 'Block C, INES Campus', 'high', 'pending', '', '2026-05-10 08:00:00', NULL);

INSERT INTO requests (ticket, full_name, email, phone, category_id, title, description, location, priority, status, notes, submitted_at, resolved_at) VALUES
('UMG-2026-0002', 'Nkusi Bernard', 'bernard@example.com', '+250788000002', 2, 'Street light out near Gate 2', 'The main street light at Gate 2 has been off for over a week. Students are unable to walk safely at night.', 'Main Gate Area', 'medium', 'in_progress', 'Bulb ordered and technician scheduled for this week.', '2026-05-11 09:30:00', NULL);

INSERT INTO requests (ticket, full_name, email, phone, category_id, title, description, location, priority, status, notes, submitted_at, resolved_at) VALUES
('UMG-2026-0003', 'Ingabire Claire', 'claire@example.com', '+250788000003', 3, 'Garbage bins overflowing at Cafeteria', 'Garbage bins in the cafeteria area have not been emptied for 4 days and are completely overflowing.', 'Cafeteria Block', 'low', 'resolved', 'Bins emptied and cleaning schedule updated.', '2026-05-08 11:00:00', '2026-05-09 16:00:00');

-- ============================================
-- 8. ADD HISTORY FOR SAMPLE REQUESTS
-- ============================================

-- History for Request #1 (UMG-2026-0001)
INSERT INTO request_history (request_id, old_status, new_status, changed_by, notes, changed_at) VALUES
(1, 'new', 'pending', 'System', 'Request submitted online', '2026-05-10 08:00:00');

-- History for Request #2 (UMG-2026-0002)
INSERT INTO request_history (request_id, old_status, new_status, changed_by, notes, changed_at) VALUES
(2, 'new', 'pending', 'System', 'Request submitted online', '2026-05-11 09:30:00');
INSERT INTO request_history (request_id, old_status, new_status, changed_by, notes, changed_at) VALUES
(2, 'pending', 'in_progress', 'Service Officer', 'Assigned technician, bulb on order', '2026-05-12 14:00:00');

-- History for Request #3 (UMG-2026-0003)
INSERT INTO request_history (request_id, old_status, new_status, changed_by, notes, changed_at) VALUES
(3, 'new', 'pending', 'System', 'Request submitted online', '2026-05-08 11:00:00');
INSERT INTO request_history (request_id, old_status, new_status, changed_by, notes, changed_at) VALUES
(3, 'pending', 'in_progress', 'Service Officer', 'Cleaning team dispatched', '2026-05-08 15:00:00');
INSERT INTO request_history (request_id, old_status, new_status, changed_by, notes, changed_at) VALUES
(3, 'in_progress', 'resolved', 'Service Officer', 'Bins emptied and schedule fixed', '2026-05-09 16:00:00');

-- 9. VERIFY DATA COUNTS (Optional - for checking)
SELECT 'Setup Complete!' AS Status;
SELECT COUNT(*) AS TotalCategories FROM categories;
SELECT COUNT(*) AS TotalUsers FROM users;
SELECT COUNT(*) AS TotalRequests FROM requests;
SELECT COUNT(*) AS TotalHistory FROM request_history;