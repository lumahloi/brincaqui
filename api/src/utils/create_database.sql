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
    brin_socials JSON,
    brin_description TEXT,
    brin_times JSON,
    brin_commodities JSON,
    brin_prices JSON,
    brin_discounts JSON,
    brin_telephone VARCHAR(11),
    brin_email VARCHAR(25),
    brin_name VARCHAR(45),
    brin_cnpj VARCHAR(14),
    brin_ages JSON,
    Usuario_user_id INT NOT NULL,
    brin_faves INT,
    brin_visits INT,
    brin_active CHAR(1),
    FOREIGN KEY (Usuario_user_id) REFERENCES Usuario (user_id)
  ) ENGINE = InnoDB;

CREATE TABLE
  IF NOT EXISTS Comodidade (
    com_id INT AUTO_INCREMENT,
    com_title VARCHAR(30) NOT NULL,
    com_creation DATE NOT NULL,
    com_active CHAR(1) NOT NULL,
    com_lastedit DATE NOT NULL,
    PRIMARY KEY (com_id)
  );

CREATE TABLE
  IF NOT EXISTS Desconto (
    disc_id INT AUTO_INCREMENT,
    disc_title VARCHAR(100) NOT NULL,
    disc_creation DATE NOT NULL,
    disc_active CHAR(1) NOT NULL,
    disc_lastedit DATE NOT NULL,
    PRIMARY KEY (disc_id)
  );

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
  Comodidade (com_title, com_creation, com_active, com_lastedit)
VALUES
  ('Ambiente climatizado', CURDATE(), 1, CURDATE()),
  ('Vídeo Games', CURDATE(), 1, CURDATE()),
  ('Oficina de Artes', CURDATE(), 1, CURDATE()),
  ('Leitura', CURDATE(), 1, CURDATE()),
  ('Piscina de Bolinhas', CURDATE(), 1, CURDATE()),
  ('Brinquedoteca', CURDATE(), 1, CURDATE()),
  ('Pintura Facial', CURDATE(), 1, CURDATE()),
  ('Filmes', CURDATE(), 1, CURDATE()),
  (
    'Atividades Sensoriais',
    CURDATE(),
    1,
    CURDATE()
  ),
  (
    'Monitoramento por Câmeras',
    CURDATE(),
    1,
    CURDATE()
  ),
  (
    'Piso Emborrachado Antialérgico',
    CURDATE(),
    1,
    CURDATE()
  ),
  ('Banheiro Adaptado', CURDATE(), 1, CURDATE()),
  ('Controle de Entrada', CURDATE(), 1, CURDATE()),
  ('Higienização Diária', CURDATE(), 1, CURDATE()),
  ('Lanchonete', CURDATE(), 1, CURDATE()),
  ('Bebedouros', CURDATE(), 1, CURDATE()),
  ('Área de Amamentação', CURDATE(), 1, CURDATE()),
  (
    'Micro-ondas Disponível',
    CURDATE(),
    1,
    CURDATE()
  ),
  ('Espaço para Festas', CURDATE(), 1, CURDATE()),
  ('Oficina de Culinária', CURDATE(), 1, CURDATE()),
  ('Oficina de Slime', CURDATE(), 1, CURDATE()),
  ('Atividades Bilíngues', CURDATE(), 1, CURDATE()),
  (
    'Programações Pedagógicas',
    CURDATE(),
    1,
    CURDATE()
  ),
  ('Lanche Gratuito', CURDATE(), 1, CURDATE()),
  (
    'Presença de Monitores',
    CURDATE(),
    1,
    CURDATE()
  ),
  (
    'Ambiente Esterilizado',
    CURDATE(),
    1,
    CURDATE()
  );

INSERT INTO
  Desconto (
    disc_title,
    disc_creation,
    disc_active,
    disc_lastedit
  )
VALUES
  ('Gestantes', CURDATE(), 1, CURDATE()),
  ('Lactantes', CURDATE(), 1, CURDATE()),
  (
    'Pessoas com Criança de Colo',
    CURDATE(),
    1,
    CURDATE()
  ),
  (
    'Pessoas com deficiência (PCD)',
    CURDATE(),
    1,
    CURDATE()
  ),
  ('Neurodivergentes', CURDATE(), 1, CURDATE()),
  ('Idosos', CURDATE(), 1, CURDATE()),
  (
    'Famílias de Baixa Renda',
    CURDATE(),
    1,
    CURDATE()
  ),
  ('Estudantes', CURDATE(), 1, CURDATE()),
  ('Combo Familiar', CURDATE(), 1, CURDATE()),
  ('Aniversário', CURDATE(), 1, CURDATE()),
  (
    'Parceria com Escolas ou Empresas',
    CURDATE(),
    1,
    CURDATE()
  ),
  ('Plano Fidelidade', CURDATE(), 1, CURDATE()),
  ('Reserva Online', CURDATE(), 1, CURDATE());

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
