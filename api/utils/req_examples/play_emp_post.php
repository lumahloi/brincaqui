<?php
require_once "test_auth_header.php";

$data = [
  'description' => 'Por conseguinte, o início da atividade geral de formação de atitudes causa impacto indireto na reavaliação dos métodos utilizados na avaliação de resultados. Evidentemente, o comprometimento entre as equipes talvez venha a ressaltar a relatividade da gestão inovadora da qual fazemos parte',
  'cnpj' => '12345678000100',
  'name' => 'Paraíso das Crianças',
  'telephone' => '21978498626',
  'email' => 'contato@paraisodascriancas.com',
  'pictures' => [
    ['picture_name'=>'foto1.jpg'],
    ['picture_name'=>'foto2.jpg']
  ],
  'socials' => [
    ['socials_name'=>'facebook', 'socials_url'=>'https://www.facebook.com/paraisodascriancas'],
    ['socials_name'=>'instagram', 'socials_url'=>'https://www.instagram.com/paraisodascriancas']
  ],
  'prices' => [
    ['prices_title'=>'Passaporte Diário', 'prices_price'=>50],
    ['prices_title'=>'1 hora', 'prices_price'=>20],
  ],
  'times' => [
    ['domingo' => '10:00-22:00'],
    ['segunda' => '10:00-22:00'],
    ['terca' => '10:00-22:00'],
    ['quarta' => '10:00-22:00'],
    ['quinta' => '10:00-22:00'],
    ['sexta' => '10:00-22:00'],
    ['sabado' => '10:00-22:00'],
    ['feriado' => '10:00-22:00']
  ],
  'commodities' => [1,2,6,7],
  'discounts' => [4,5],
  'ages' => [5,6,7,8,9,10,11,12,13,14],
  'cep' => '21339825',
  'streetnum' => 'Rua Palmeirense Agostinho 388',
  'city' => 'Rio de Janeiro',
  'neighborhood' => 'Belford Roxo',
  'plus' => 'Casa 2',
  'state' => 'Rio de Janeiro',
  'country' => 'Brasil'
];

$ch = curl_init('http://localhost/brincaqui/api/play/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: $cookie"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
