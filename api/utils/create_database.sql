CREATE DATABASE IF NOT EXISTS Brincaqui;

USE Brincaqui;

CREATE TABLE
  IF NOT EXISTS TipoUsuario (id INT PRIMARY KEY, nome VARCHAR(20) NOT NULL);

CREATE TABLE
  IF NOT EXISTS Usuario (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(45) NOT NULL,
    user_telephone VARCHAR(11) NOT NULL,
    user_email VARCHAR(40) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_type INT NOT NULL,
    user_active CHAR(1) NOT NULL,
    user_creation DATE NOT NULL,
    user_lastedit DATE NOT NULL,
    FOREIGN KEY (user_type) REFERENCES TipoUsuario (id)
  );

CREATE TABLE
  IF NOT EXISTS Brinquedo (
    brin_id INT AUTO_INCREMENT PRIMARY KEY,
    brin_pictures JSON,
    brin_grade FLOAT,
    brin_grade_2 FLOAT,
    brin_grade_3 FLOAT,
    brin_grade_4 FLOAT,
    brin_grade_5 FLOAT,
    brin_grade_6 FLOAT,
    brin_grade_7 FLOAT,
    brin_socials JSON NOT NULL,
    brin_description TEXT,
    brin_times JSON NOT NULL,
    brin_commodities JSON NOT NULL,
    brin_prices JSON NOT NULL,
    brin_discounts JSON,
    brin_telephone VARCHAR(11) NOT NULL,
    brin_email VARCHAR(25) NOT NULL,
    brin_name VARCHAR(45) NOT NULL,
    brin_cnpj VARCHAR(14) NOT NULL,
    brin_ages JSON NOT NULL,
    Usuario_user_id INT NOT NULL,
    brin_faves INT,
    brin_visits INT,
    brin_active CHAR(1) NOT NULL,
    FOREIGN KEY (Usuario_user_id) REFERENCES Usuario (user_id)
  ) ENGINE = InnoDB;

CREATE TABLE
  IF NOT EXISTS Endereco (
    add_cep VARCHAR(8) NOT NULL,
    add_streetnum VARCHAR(100) NOT NULL,
    add_city VARCHAR(20) NOT NULL,
    add_neighborhood VARCHAR(20) NOT NULL,
    add_plus VARCHAR(100),
    Brinquedo_brin_id INT NOT NULL,
    add_state VARCHAR(30) NOT NULL,
    add_country VARCHAR(20) NOT NULL,
    PRIMARY KEY (Brinquedo_brin_id),
    add_latitude DECIMAL(10, 8) NOT NULL,
    add_longitude DECIMAL(11, 8) NOT NULL,
    FOREIGN KEY (Brinquedo_brin_id) REFERENCES Brinquedo (brin_id)
  );

CREATE TABLE
  IF NOT EXISTS Favorito (
    Usuario_user_id INT NOT NULL,
    Brinquedo_brin_id INT NOT NULL,
    PRIMARY KEY (Usuario_user_id, Brinquedo_brin_id),
    FOREIGN KEY (Usuario_user_id) REFERENCES Usuario (user_id),
    FOREIGN KEY (Brinquedo_brin_id) REFERENCES Brinquedo (brin_id)
  );

CREATE TABLE
  IF NOT EXISTS Avaliacao (
    Usuario_user_id INT NOT NULL,
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
    FOREIGN KEY (Usuario_user_id) REFERENCES Usuario (user_id),
    FOREIGN KEY (Brinquedo_brin_id) REFERENCES Brinquedo (brin_id)
  );

CREATE TABLE
  IF NOT EXISTS Notificacao (
    notif_id INT NOT NULL AUTO_INCREMENT,
    notif_title VARCHAR(60) NOT NULL,
    notif_description TEXT NOT NULL,
    notif_creation DATE NOT NULL,
    notif_active CHAR(1) NOT NULL,
    notif_lastedit DATE NOT NULL,
    PRIMARY KEY (notif_id)
  );

CREATE TABLE
  IF NOT EXISTS Visita (
    Usuario_user_id INT NOT NULL,
    Brinquedo_brin_id INT NOT NULL,
    visit_date DATE NOT NULL,
    PRIMARY KEY (Usuario_user_id, Brinquedo_brin_id, visit_date),
    FOREIGN KEY (Usuario_user_id) REFERENCES Usuario (user_id),
    FOREIGN KEY (Brinquedo_brin_id) REFERENCES Brinquedo (brin_id)
  );

INSERT INTO
  TipoUsuario (id, nome)
VALUES
  (1, 'cliente'),
  (2, 'empresa'),
  (3, 'admin');

INSERT INTO
  Notificacao (
    notif_title,
    notif_description,
    notif_creation,
    notif_active,
    notif_lastedit
  )
VALUES
  (
    'Avalie sua experiência!',
    'Sua opinião é muito importante para nós e outros pais. Avalie sua experiência em {brinquedo}.',
    CURDATE(),
    1,
    CURDATE()
  ),
  (
    '{brinquedo} te aguarda',
    'Que tal visitar {brinquedo} novamente?',
    CURDATE(),
    1,
    CURDATE()
  );