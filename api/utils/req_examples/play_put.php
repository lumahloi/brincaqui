<?php
require_once "../../base_dir.php";
require_once BASE_DIR . "/utils/load_env.php";
load_env(BASE_DIR . '/.env');
session_id(getenv('SESSION_ID'));
session_start();

$cookie = "PHPSESSID=" . session_id();

$data = [
  'description' => 'testeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee',
  'name' => 'teste',
  'telephone' => '12345678901',
  'email' => 'teste@teste.com',
  'pictures' => [
    ['picture_name'=>'teste.jpg']
  ],
  'socials' => [
    ['socials_name'=>'teste', 'socials_url'=>'https://www.facebook.com/paraisodascriancas']
  ],
  'prices' => [
    ['prices_title'=>'Teste', 'prices_price'=>50]
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
  'commodities' => [1],
  'discounts' => [1],
  'ages' => [1]
];

$ch = curl_init('http://localhost/brincaqui/api/play/4?params=description,name,telephone,email,pictures,socials,prices,times,commodities,discounts,ages,active');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    "Cookie: $cookie"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
