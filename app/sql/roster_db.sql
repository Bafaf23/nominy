-- Desarrollador: Bryant Facenda
CREATE DATABASE IF NOT EXISTS roster_db;

USE roster_db;

---------------------------------------------------------
-- *1. DEFINICIÓN DEL SCHEMA (ESTRUCTURA)
---------------------------------------------------------
-- Tabla roles
CREATE TABLE IF NOT EXISTS roles(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name_role VARCHAR(255) NOT NULL UNIQUE,
  salary DECIMAL(10.2)
)

-- Tabla bonos
CREATE TABLE IF NOT EXISTS bonuses(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name_bonuses VARCHAR(255),
  amount DECIMAL(10,2)
)


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

  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (id_bonuses) REFERENCES bonuses(id) ON DELETE SET NULL,
  FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE RESTRICT
)



---------------------------------------------------------
-- *2. INSERCIÓN DE DATOS
---------------------------------------------------------

-- Users
--!Este es el usurio poderoso Usasalo con sabiduria
INSERT INTO users (dni, name, last_name, email, pass, date_entry, id_role) VALUE("V-00001", "Angelica", "Rivas", "superadmin@mominy.com", "admin123", "1-01-1999", 6)