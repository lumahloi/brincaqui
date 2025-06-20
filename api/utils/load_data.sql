INSERT INTO 
Usuario
(user_name, user_telephone, user_email, user_password, user_type, user_active, user_creation, user_lastedit)
VALUES 
('Cliente Teste', '21973656983', 'testecliente@email.com', '$2y$12$dzGTYeOLCqMYiiWIEOHjdez.eh3sReet2ZEOvWvNTNLHKWHviBw1a', 1, 1, CURDATE(), CURRDATE()), 
('Empresa Teste', '21973656355', 'testeempresa@email.com', '$2y$12$dzGTYeOLCqMYiiWIEOHjdez.eh3sReet2ZEOvWvNTNLHKWHviBw1a', 1, 1, CURDATE(), CURRDATE());


INSERT INTO Brinquedo (
  brin_grade,
  brin_grade_2,
  brin_grade_3,
  brin_grade_4,
  brin_grade_5,
  brin_grade_6,
  brin_grade_7,
  brin_socials,
  brin_times,
  brin_commodities,
  brin_prices,
  brin_discounts,
  brin_telephone,
  brin_email,
  brin_name,
  brin_cnpj,
  brin_ages,
  Usuario_user_id,
  brin_active,
  brin_faves,
  brin_visits
)
VALUES
(8.5, 7.2, 9.1, 8.0, 6.7, 7.8, 8.3,
  JSON_OBJECT("instagram", "@playzone1", "facebook", "fb.com/playzone1"),
  JSON_ARRAY(
    JSON_OBJECT("domingo", "10:00-22:00"),
    JSON_OBJECT("segunda", "10:00-22:00"),
    JSON_OBJECT("terca", "10:00-22:00"),
    JSON_OBJECT("quarta", "10:00-22:00"),
    JSON_OBJECT("quinta", "10:00-22:00"),
    JSON_OBJECT("sexta", "10:00-22:00"),
    JSON_OBJECT("sabado", "10:00-22:00"),
    JSON_OBJECT("feriado", "10:00-22:00")
  ),
  JSON_ARRAY("1", "2"),
  JSON_ARRAY(
    JSON_OBJECT("prices_title", "Passaporte Diário", "prices_price", 50),
    JSON_OBJECT("prices_title", "1 hora", "prices_price", 20)
  ),
  JSON_ARRAY("1", "3"),
  '11999990001',
  'contato1@playzone.com',
  'PlayZone Aventura',
  '12345678000191',
  JSON_ARRAY("0-2 anos", "3-5 anos", "6-8 anos"),
  2,
  '1',
  10,
  50
),
(9.2, 8.4, 9.5, 7.7, 9.0, 8.8, 9.1,
  JSON_OBJECT("instagram", "@diverparque", "facebook", "fb.com/diverparque"),
  JSON_ARRAY(
    JSON_OBJECT("domingo", "10:00-22:00"),
    JSON_OBJECT("segunda", "10:00-22:00"),
    JSON_OBJECT("terca", "10:00-22:00"),
    JSON_OBJECT("quarta", "10:00-22:00"),
    JSON_OBJECT("quinta", "10:00-22:00"),
    JSON_OBJECT("sexta", "10:00-22:00"),
    JSON_OBJECT("sabado", "10:00-22:00"),
    JSON_OBJECT("feriado", "10:00-22:00")
  ),
  JSON_ARRAY("2", "4"),
  JSON_ARRAY(
    JSON_OBJECT("prices_title", "1 hora", "prices_price", 25),
    JSON_OBJECT("prices_title", "30 minutos", "prices_price", 15)
  ),
  JSON_ARRAY("2"),
  '11999990002',
  'contato2@diverparque.com',
  'DiverParque Kids',
  '98765432000100',
  JSON_ARRAY("3-5 anos", "6-8 anos"),
  2,
  '1',
  25,
  100
),
(7.8, 6.5, 8.0, 7.1, 6.9, 7.3, 7.0,
  JSON_OBJECT("instagram", "@fantasiland"),
  JSON_ARRAY(
    JSON_OBJECT("domingo", "10:00-22:00"),
    JSON_OBJECT("segunda", "10:00-22:00"),
    JSON_OBJECT("terca", "10:00-22:00"),
    JSON_OBJECT("quarta", "10:00-22:00"),
    JSON_OBJECT("quinta", "10:00-22:00"),
    JSON_OBJECT("sexta", "10:00-22:00"),
    JSON_OBJECT("sabado", "10:00-22:00"),
    JSON_OBJECT("feriado", "10:00-22:00")
  ),
  JSON_ARRAY("1"),
  JSON_ARRAY(
    JSON_OBJECT("prices_title", "Ingresso Único", "prices_price", 30)
  ),
  NULL,
  '11999990003',
  'info@fantasiland.com',
  'Fantasiland',
  '11222333000155',
  JSON_ARRAY("0-2 anos", "3-5 anos"),
  2,
  '1',
  15,
  60
),
(8.9, 8.1, 9.3, 8.0, 7.9, 8.6, 8.8,
  JSON_OBJECT("instagram", "@mundoalegria"),
  JSON_ARRAY(
    JSON_OBJECT("domingo", "10:00-22:00"),
    JSON_OBJECT("segunda", "10:00-22:00"),
    JSON_OBJECT("terca", "10:00-22:00"),
    JSON_OBJECT("quarta", "10:00-22:00"),
    JSON_OBJECT("quinta", "10:00-22:00"),
    JSON_OBJECT("sexta", "10:00-22:00"),
    JSON_OBJECT("sabado", "10:00-22:00"),
    JSON_OBJECT("feriado", "10:00-22:00")
  ),
  JSON_ARRAY("3", "4"),
  JSON_ARRAY(
    JSON_OBJECT("prices_title", "Diária", "prices_price", 45)
  ),
  JSON_ARRAY("1", "2"),
  '11999990004',
  'contato@mundoalegria.com',
  'Mundo Alegria',
  '55667788000133',
  JSON_ARRAY("6-8 anos", "9-12 anos"),
  2,
  '1',
  12,
  80
),
(7.5, 6.2, 6.9, 7.3, 7.1, 6.8, 6.5,
  JSON_OBJECT("facebook", "fb.com/magickids"),
  JSON_ARRAY(
    JSON_OBJECT("domingo", "10:00-22:00"),
    JSON_OBJECT("segunda", "10:00-22:00"),
    JSON_OBJECT("terca", "10:00-22:00"),
    JSON_OBJECT("quarta", "10:00-22:00"),
    JSON_OBJECT("quinta", "10:00-22:00"),
    JSON_OBJECT("sexta", "10:00-22:00"),
    JSON_OBJECT("sabado", "10:00-22:00"),
    JSON_OBJECT("feriado", "10:00-22:00")
  ),
  JSON_ARRAY("2"),
  JSON_ARRAY(
    JSON_OBJECT("prices_title", "Hora Feliz", "prices_price", 10)
  ),
  NULL,
  '11999990005',
  'email@magickids.com',
  'Magic Kids',
  '11112222333344',
  JSON_ARRAY("3-5 anos"),
  2,
  '1',
  5,
  30
),
(9.0, 8.6, 9.2, 8.3, 9.1, 9.0, 8.9,
  JSON_OBJECT("instagram", "@aventurapark"),
  JSON_ARRAY(
    JSON_OBJECT("domingo", "10:00-22:00"),
    JSON_OBJECT("segunda", "10:00-22:00"),
    JSON_OBJECT("terca", "10:00-22:00"),
    JSON_OBJECT("quarta", "10:00-22:00"),
    JSON_OBJECT("quinta", "10:00-22:00"),
    JSON_OBJECT("sexta", "10:00-22:00"),
    JSON_OBJECT("sabado", "10:00-22:00"),
    JSON_OBJECT("feriado", "10:00-22:00")
  ),
  JSON_ARRAY("1", "3"),
  JSON_ARRAY(
    JSON_OBJECT("prices_title", "Ingresso Integral", "prices_price", 60)
  ),
  JSON_ARRAY("2", "3"),
  '11999990006',
  'hello@aventurapark.com',
  'Aventura Park',
  '99988877000111',
  JSON_ARRAY("0-2 anos", "6-8 anos", "9-12 anos"),
  2,
  '1',
  40,
  120
),
(8.0, 7.1, 7.5, 7.9, 7.6, 8.0, 7.8,
  JSON_OBJECT("instagram", "@kidsplanet"),
  JSON_ARRAY(
    JSON_OBJECT("domingo", "10:00-22:00"),
    JSON_OBJECT("segunda", "10:00-22:00"),
    JSON_OBJECT("terca", "10:00-22:00"),
    JSON_OBJECT("quarta", "10:00-22:00"),
    JSON_OBJECT("quinta", "10:00-22:00"),
    JSON_OBJECT("sexta", "10:00-22:00"),
    JSON_OBJECT("sabado", "10:00-22:00"),
    JSON_OBJECT("feriado", "10:00-22:00")
  ),
  JSON_ARRAY("1", "2"),
  JSON_ARRAY(
    JSON_OBJECT("prices_title", "Ingresso Simples", "prices_price", 35)
  ),
  JSON_ARRAY("1"),
  '11999990007',
  'contato@kidsplanet.com',
  'Kids Planet',
  '99887766000122',
  JSON_ARRAY("3-5 anos", "6-8 anos"),
  2,
  '1',
  18,
  75
);



INSERT INTO Endereco (
  add_cep, add_streetnum, add_city, add_neighborhood, add_plus, Brinquedo_brin_id, add_state, add_country, add_latitude, add_longitude
)
VALUES
('12345678', 'Rua das Flores, 100', 'São Paulo', 'Centro', 'Próximo à praça', 1, 'SP', 'Brasil', -23.550520, -46.633308),
('23456789', 'Av. Paulista, 2000', 'São Paulo', 'Bela Vista', NULL, 2, 'SP', 'Brasil', -23.561684, -46.655981),
('34567890', 'Rua Alegre, 50', 'Campinas', 'Jardim das Rosas', NULL, 3, 'SP', 'Brasil', -22.905560, -47.060830),
('45678901', 'Av. das Nações, 300', 'Santos', 'Gonzaga', 'Perto da praia', 4, 'SP', 'Brasil', -23.967529, -46.328472),
('56789012', 'Rua da Criança, 77', 'Ribeirão Preto', 'Centro', NULL, 5, 'SP', 'Brasil', -21.178403, -47.810323),
('67890123', 'Av. Felicidade, 88', 'Bauru', 'Zona Sul', NULL, 6, 'SP', 'Brasil', -22.314459, -49.058695),
('78901234', 'Rua Encanto, 121', 'Sorocaba', 'Vila Nova', 'Ao lado do shopping', 7, 'SP', 'Brasil', -23.500000, -47.450000)
