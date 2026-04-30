-- Desarrollador: Bryant Facenda
-- Proyecto: Nominy - Sistema de Nómina
CREATE DATABASE IF NOT EXISTS roster_db;
USE roster_db;

---------------------------------------------------------
-- 1. TABLAS MAESTRAS (Sin dependencias)
---------------------------------------------------------

CREATE TABLE IF NOT EXISTS roles(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name_role VARCHAR(255) NOT NULL UNIQUE,
  salary DECIMAL(10,2)
);

CREATE TABLE IF NOT EXISTS bonuses(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name_bonuses VARCHAR(255),
  amount DECIMAL(10,2)
);

CREATE TABLE IF NOT EXISTS bank(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name_bank VARCHAR(255) NOT NULL,
  account VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS deductions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_deduction VARCHAR(100) NOT NULL,
    description TEXT,
    type ENUM('percentage', 'fixed') DEFAULT 'fixed',
    amount DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

---------------------------------------------------------
-- 2. TABLA DE USUARIOS
---------------------------------------------------------

CREATE TABLE IF NOT EXISTS users(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  dni VARCHAR(20) UNIQUE, 
  name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  pass VARCHAR(255) NOT NULL,
  date_entry DATE,
  id_role INT UNSIGNED,
  id_bank INT UNSIGNED,
  is_active TINYINT(1) DEFAULT 0,
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE RESTRICT,
  FOREIGN KEY (id_bank) REFERENCES bank(id) ON DELETE RESTRICT
);

---------------------------------------------------------
-- 3. TABLAS RELACIONALES Y TRANSACCIONALES
---------------------------------------------------------

CREATE TABLE IF NOT EXISTS user_bonuses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    id_bonus INT UNSIGNED NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_bonus) REFERENCES bonuses(id) ON DELETE CASCADE
);

-- Esta tabla es la que usa tu controlador para el pago individual
CREATE TABLE IF NOT EXISTS individual_payments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    amount DECIMAL(10,2) NOT NULL,       -- Monto Neto
    sso_amount DECIMAL(10,2) DEFAULT 0,  -- 4%
    spf_amount DECIMAL(10,2) DEFAULT 0,  -- 0.5%
    faov_amount DECIMAL(10,2) DEFAULT 0, -- 1%
    period VARCHAR(100),
    bank VARCHAR(100),
    payment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);

-- Historial para las tarjetas del dashboard
CREATE TABLE IF NOT EXISTS payroll_history (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    status ENUM('PAID', 'PENDING', 'FAILED') DEFAULT 'PAID',
    periode VARCHAR(100),
    monto_pagado DECIMAL(10,2),
    bank VARCHAR(100),
    date DATETIME DEFAULT CURRENT_TIMESTAMP
);

---------------------------------------------------------
-- 4. INSERCIÓN DE DATOS INICIALES
---------------------------------------------------------

INSERT INTO roles (name_role, salary) VALUES 
("Development", 1000), 
("RRHH", 500), 
("Marketing", 670), 
("QA", 1000), 
("Design", 700), 
("Accounting and Sales", 800);

INSERT INTO bank (name_bank, account) VALUES 
("BBVA Provincial", "0108-XXXX-XXXX-XXXX"), 
("Banesco", "0134-XXXX-XXXX-XXXX"), 
("Mercantil", "0105-XXXX-XXXX-XXXX");

INSERT INTO deductions (name_deduction, description, type, amount) VALUES 
('SSO', 'Seguro Social (4%)', 'percentage', 4.00),
('SPF', 'Paro Forzoso (0.5%)', 'percentage', 0.50),
('FAOV', 'Vivienda y Hábitat (1%)', 'percentage', 1.00);

INSERT INTO bonuses (name_bonuses, amount) VALUES 
('Bono de Alimentación', 40.00),
('Bono de Transporte', 20.00),
('Bono por Asistencia', 15.00),
('Bono de Productividad', 50.00),
('Bono de Antigüedad', 30.00);

-- Usuario Admin para el profesor
-- Nota: La clave aquí es texto plano, recuerda usar password_hash en tu PHP
INSERT INTO users (dni, name, last_name, email, pass, date_entry, id_role, id_bank, is_active) 
VALUES ("V-00001", "Angelica", "Rivas", "superadmin@nominy.com", "admin123", "2026-01-01", 2, 1, 1);