-- HRMS Database Schema
-- Human Resource Management System

-- Create database
CREATE DATABASE IF NOT EXISTS hrms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hrms_db;

-- Users table (for authentication)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'hr', 'employee') NOT NULL DEFAULT 'employee',
    is_active TINYINT(1) DEFAULT 1,
    last_login DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Departments table
CREATE TABLE departments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Designations table
CREATE TABLE designations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Cadres table
CREATE TABLE cadres (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    salary_scale DECIMAL(10,2) DEFAULT 0.00,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Shifts table
CREATE TABLE shifts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    working_days VARCHAR(50) DEFAULT 'Monday,Tuesday,Wednesday,Thursday,Friday',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Employees table
CREATE TABLE employees (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    employee_code VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    nic VARCHAR(20) UNIQUE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    date_of_birth DATE NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    department_id INT,
    designation_id INT,
    cadre_id INT,
    shift_id INT,
    salary_type ENUM('daily', 'monthly') NOT NULL DEFAULT 'monthly',
    daily_basic_rate DECIMAL(10,2) DEFAULT 0.00,
    monthly_basic_rate DECIMAL(10,2) DEFAULT 0.00,
    profile_photo VARCHAR(255),
    joining_date DATE NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
    FOREIGN KEY (designation_id) REFERENCES designations(id) ON DELETE SET NULL,
    FOREIGN KEY (cadre_id) REFERENCES cadres(id) ON DELETE SET NULL,
    FOREIGN KEY (shift_id) REFERENCES shifts(id) ON DELETE SET NULL
);

-- Attendance table
CREATE TABLE attendances (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT NOT NULL,
    date DATE NOT NULL,
    in_time TIME,
    out_time TIME,
    worked_hours DECIMAL(4,2) DEFAULT 0.00,
    is_late TINYINT(1) DEFAULT 0,
    is_early_leave TINYINT(1) DEFAULT 0,
    is_absent TINYINT(1) DEFAULT 0,
    status ENUM('present', 'absent', 'late', 'early_leave', 'half_day') DEFAULT 'present',
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    UNIQUE KEY unique_attendance (employee_id, date)
);

-- Leave types table
CREATE TABLE leave_types (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    default_days INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Leaves table
CREATE TABLE leaves (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT NOT NULL,
    leave_type_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_days DECIMAL(3,1) NOT NULL,
    reason TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    approved_by INT,
    approved_at DATETIME,
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (leave_type_id) REFERENCES leave_types(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Salary payments table
CREATE TABLE salary_payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT NOT NULL,
    month INT NOT NULL,
    year INT NOT NULL,
    basic_salary DECIMAL(10,2) NOT NULL,
    present_days INT DEFAULT 0,
    absent_days INT DEFAULT 0,
    leave_days INT DEFAULT 0,
    deductions DECIMAL(10,2) DEFAULT 0.00,
    allowances DECIMAL(10,2) DEFAULT 0.00,
    net_salary DECIMAL(10,2) NOT NULL,
    payment_date DATE,
    payment_status ENUM('pending', 'paid') DEFAULT 'pending',
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    UNIQUE KEY unique_salary (employee_id, month, year)
);

-- Holidays table
CREATE TABLE holidays (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    description TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Settings table
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default data

-- Default admin user (password: admin123)
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@hrms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Default departments
INSERT INTO departments (name, description) VALUES 
('Information Technology', 'IT Department'),
('Human Resources', 'HR Department'),
('Finance', 'Finance Department'),
('Marketing', 'Marketing Department'),
('Operations', 'Operations Department');

-- Default designations
INSERT INTO designations (name, description) VALUES 
('Manager', 'Department Manager'),
('Senior Executive', 'Senior Level Executive'),
('Executive', 'Mid Level Executive'),
('Assistant', 'Junior Level Assistant'),
('Intern', 'Internship Position');

-- Default cadres
INSERT INTO cadres (name, description, salary_scale) VALUES 
('Technical Officer', 'Technical position with specialized skills', 50000.00),
('Assistant', 'Support staff position', 30000.00),
('Clerk', 'Administrative clerk position', 25000.00),
('Supervisor', 'Supervisory position', 40000.00),
('Senior Officer', 'Senior level position', 45000.00);

-- Default shifts
INSERT INTO shifts (name, start_time, end_time, working_days) VALUES 
('Morning Shift', '08:00:00', '17:00:00', 'Monday,Tuesday,Wednesday,Thursday,Friday'),
('Evening Shift', '14:00:00', '23:00:00', 'Monday,Tuesday,Wednesday,Thursday,Friday'),
('Night Shift', '22:00:00', '07:00:00', 'Monday,Tuesday,Wednesday,Thursday,Friday'),
('Weekend Shift', '09:00:00', '18:00:00', 'Saturday,Sunday');

-- Default leave types
INSERT INTO leave_types (name, description, default_days) VALUES 
('Sick Leave', 'Medical leave for illness', 14),
('Casual Leave', 'Personal leave for casual purposes', 7),
('Annual Leave', 'Annual vacation leave', 21),
('No Pay Leave', 'Leave without pay', 0),
('Maternity Leave', 'Leave for expecting mothers', 90);

-- Default settings
INSERT INTO settings (setting_key, setting_value, description) VALUES 
('company_name', 'HRMS Company', 'Company name'),
('company_address', '123 Business Street, City, Country', 'Company address'),
('company_phone', '+1234567890', 'Company phone number'),
('company_email', 'info@hrms.com', 'Company email'),
('working_hours', '8', 'Standard working hours per day'),
('late_threshold', '15', 'Late threshold in minutes'),
('salary_day', '25', 'Salary payment day of month');

-- Sample employees
INSERT INTO users (username, email, password, role) VALUES 
('john.doe', 'john.doe@hrms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee'),
('jane.smith', 'jane.smith@hrms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employee');

INSERT INTO employees (user_id, employee_code, full_name, nic, gender, date_of_birth, phone, email, address, department_id, designation_id, cadre_id, shift_id, salary_type, monthly_basic_rate, joining_date) VALUES 
(2, 'EMP001', 'John Doe', '1234567890123', 'male', '1990-05-15', '+1234567890', 'john.doe@hrms.com', '123 Main St, City', 1, 1, 1, 1, 'monthly', 50000.00, '2023-01-15'),
(3, 'EMP002', 'Jane Smith', '9876543210987', 'female', '1988-08-22', '+1234567891', 'jane.smith@hrms.com', '456 Oak Ave, Town', 2, 2, 2, 1, 'monthly', 40000.00, '2023-02-01');