-- Desarrollador: Bryant Facenda
CREATE DATABASE IF NOT EXISTS roster_db;

USE roster_db;

---------------------------------------------------------
-- *1. DEFINICIÓN DEL SCHEMA (ESTRUCTURA)
---------------------------------------------------------
-- 1. Tablas Maestras (Independientes)
CREATE TABLE IF NOT EXISTS roles(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name_role VARCHAR(255) NOT NULL UNIQUE,
  salary DECIMAL(10,2)
)

-- 2. Tabla bonos
CREATE TABLE IF NOT EXISTS bonuses(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name_bonuses VARCHAR(255),
  amount DECIMAL(10,2)
)

-- 3. Tabla Bank
CREATE TABLE IF NOT EXISTS bank(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name_bank VARCHAR(255) NOT NULL,
  account VARCHAR(255) UNIQUE NOT NULL
)

-- 4. deducciones 
CREATE TABLE deductions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_deduction VARCHAR(100) NOT NULL, -- Ejemplo: "Seguro Social (4%)"
    description TEXT,
    type ENUM('percentage', 'fixed') DEFAULT 'fixed', -- Si es un % o un monto fijo
    amount DECIMAL(10, 2) NOT NULL, -- El valor (ejemplo: 4.00 o 50.00)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Tabla user
CREATE TABLE IF NOT EXISTS users(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  dni VARCHAR(20) UNIQUE, 
  name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  pass VARCHAR(255) NOT NULL,
  date_entry DATE,
  id_bonuses INT UNSIGNED,
  id_role INT UNSIGNED,
  id_bank INT UNSIGNED,

  is_active TINYINT(1) DEFAULT 0,
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (id_bonuses) REFERENCES bonuses(id) ON DELETE SET NULL,
  FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE RESTRICT,
  FOREIGN KEY (id_bank) REFERENCES bank(id) ON DELETE RESTRICT
);

-- 3. TABLA CLAVE: Historial de Pagos (Para las Cartas y Utilidad Real)
CREATE TABLE IF NOT EXISTS payroll_history (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    payment_date DATE NOT NULL,          -- Cuándo se pagó
    period_name VARCHAR(100),            -- Ejemplo: "1ra Quincena Abril"
    base_salary_snapshot DECIMAL(10,2),  -- Guardamos el sueldo de ese momento
    total_bonuses DECIMAL(10,2),
    total_deductions DECIMAL(10,2),
    net_amount DECIMAL(10,2),            -- Lo que llegó al banco
    status ENUM('paid', 'pending', 'failed') DEFAULT 'paid',
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);



---------------------------------------------------------
-- *2. INSERCIÓN DE DATOS
---------------------------------------------------------
-- Roles
INSERT INTO roles (name_role, salary) VALUES 
("Development", 1000), 
("RRHH", 500), 
("Marketing", 670), 
("QA", 1000), 
("Design", 700), 
("Accounting and Sales", 800);

-- Bancos
INSERT INTO bank (name_bank, account) VALUES 
("BBVA", "1234567891211"), 
("Banesco", "15536667891511"), 
("Mercantil", "14345643876511");

-- Usuario Admin (Asegúrate que el id_role 2 existe - RRHH)
INSERT INTO users (dni, name, last_name, email, pass, date_entry, id_role, id_bank) 
VALUES ("V-00001", "Angelica", "Rivas", "superadmin@nominy.com", "admin123", "1999-01-01", 2, 1);

