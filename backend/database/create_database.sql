CREATE DATABASE IF NOT EXISTS Brincaqui;
USE Brincaqui;

CREATE TABLE IF NOT EXISTS Usuario (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(45) NOT NULL,
    user_telephone VARCHAR(11) NOT NULL,
    user_email VARCHAR(25) NOT NULL,    
    user_password VARCHAR(255) NOT NULL,
    user_active CHAR(1) NOT NULL,
    user_creation DATE NOT NULL,
    user_lastedit DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS Admin (
    user_id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES Usuario(user_id)
);

CREATE TABLE IF NOT EXISTS Cliente (
    user_id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES Usuario(user_id)
);

CREATE TABLE IF NOT EXISTS Empresa (
    user_id INT AUTO_INCREMENT NOT NULL,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES Usuario(user_id)
);

CREATE TABLE IF NOT EXISTS Brinquedo (
  brin_id INT AUTO_INCREMENT PRIMARY KEY,
  brin_pictures JSON,    
  brin_grade FLOAT,
  brin_socials JSON,    
  brin_description TEXT,
  brin_times JSON NOT NULL,       
  brin_commodities JSON NOT NULL, 
  brin_prices JSON NOT NULL,     
  brin_discounts JSON NOT NULL,  
  brin_telephone JSON NOT NULL,  
  brin_email JSON NOT NULL,       
  brin_name VARCHAR(45) NOT NULL,
  brin_cnpj VARCHAR(14),
  brin_ages JSON NOT NULL,       
  Empresa_user_id INT NOT NULL,
  brin_faves INT,
  brin_visits INT,
  FOREIGN KEY (Empresa_user_id) REFERENCES Empresa(user_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Comodidade (
    com_id INT AUTO_INCREMENT,
    com_title VARCHAR(30) NOT NULL,
    com_creation DATE NOT NULL,
    com_active CHAR(1) NOT NULL,
    com_lastedit DATE NOT NULL,
    PRIMARY KEY (com_id)
);

CREATE TABLE IF NOT EXISTS Desconto (
    disc_id INT AUTO_INCREMENT,
    disc_title VARCHAR(100) NOT NULL,
    disc_creation DATE NOT NULL,
    disc_active CHAR(1) NOT NULL,
    disc_lastedit DATE NOT NULL,
    PRIMARY KEY (disc_id)
);

CREATE TABLE IF NOT EXISTS Endereco (
    add_cep VARCHAR(8) NOT NULL,
    add_streetnum VARCHAR(100) NOT NULL,
    add_city VARCHAR(20) NOT NULL,
    add_neighborhood VARCHAR(20) NOT NULL,
    add_plus VARCHAR(100),
    Brinquedo_brin_id INT NOT NULL,
    add_state VARCHAR(30) NOT NULL,
    add_country VARCHAR(20) NOT NULL,
    PRIMARY KEY (Brinquedo_brin_id),
    FOREIGN KEY (Brinquedo_brin_id) REFERENCES Brinquedo(brin_id)
);

CREATE TABLE IF NOT EXISTS Favorito (
    Cliente_user_id INT NOT NULL,
    Brinquedo_brin_id INT NOT NULL,
    PRIMARY KEY (Cliente_user_id, Brinquedo_brin_id),
    FOREIGN KEY (Cliente_user_id) REFERENCES Cliente(user_id),
    FOREIGN KEY (Brinquedo_brin_id) REFERENCES Brinquedo(brin_id)
);

CREATE TABLE IF NOT EXISTS Avaliacao (
    Cliente_user_id INT NOT NULL,
    Brinquedo_brin_id INT NOT NULL,
    aval_id INT NOT NULL AUTO_INCREMENT,
    aval_description TEXT,
    aval_date DATE NOT NULL,
    aval_grade_1 FLOAT NOT NULL,
    aval_grade_2 FLOAT NOT NULL,
    aval_grade_3 FLOAT NOT NULL,
    aval_grade_4 FLOAT NOT NULL,
    aval_grade_5 FLOAT NOT NULL,
    aval_grade_6 FLOAT NOT NULL,
    PRIMARY KEY (aval_id),
    FOREIGN KEY (Cliente_user_id) REFERENCES Cliente(user_id),
    FOREIGN KEY (Brinquedo_brin_id) REFERENCES Brinquedo(brin_id)
);

CREATE TABLE IF NOT EXISTS Notificacao (
    notif_id INT NOT NULL AUTO_INCREMENT,
    notif_title VARCHAR(60) NOT NULL,
    notif_description TEXT NOT NULL,
    notif_creation DATE NOT NULL,
    notif_active CHAR(1) NOT NULL,
    notif_lastedit DATE NOT NULL,
    PRIMARY KEY (notif_id)
);

CREATE TABLE IF NOT EXISTS Visita (
    Cliente_user_id INT NOT NULL,
    Brinquedo_brin_id INT NOT NULL,
    visit_date DATE NOT NULL,
    PRIMARY KEY (Cliente_user_id, Brinquedo_brin_id, visit_date),
    FOREIGN KEY (Cliente_user_id) REFERENCES Cliente(user_id),
    FOREIGN KEY (Brinquedo_brin_id) REFERENCES Brinquedo(brin_id)
);