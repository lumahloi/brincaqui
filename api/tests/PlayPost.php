<?php

use PHPUnit\Framework\TestCase;

class EmpPost extends TestCase
{
    private $loginUrl = 'http://localhost/brincaqui/api/auth/login.php';
    private $playUrl = 'http://localhost/brincaqui/api/play/1'; // O ID pode ser qualquer valor, pois será ignorado no POST

    private function loginAndGetSessionCookie()
    {
        $loginData = [
            'email' => 'lumahcliente@gmail.com', // Use um usuário válido do tipo empresa
            'password' => 'admin@123'
        ];

        $ch = curl_init($this->loginUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($loginData));
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);

        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches);
        $cookies = [];
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        curl_close($ch);

        return $cookies['PHPSESSID'] ?? null;
    }

    public function testEmpPostSuccess()
    {
        $sessionId = $this->loginAndGetSessionCookie();
        $this->assertNotEmpty($sessionId, 'Sessão não criada no login.');

        $data = [
            'description' => str_repeat('Descrição válida. ', 20), // >= 200 caracteres
            'name' => 'Brinquedo Teste ' . rand(1000,9999),
            'cnpj' => '12345678000199',
            'telephone' => '11999999999',
            'email' => 'empresa' . rand(1000,9999) . '@exemplo.com',
            'pictures' => [
                ['picture_name' => 'foto1.jpg'],
                ['picture_name' => 'foto2.jpg']
            ],
            'socials' => [
                ['socials_name' => 'Instagram', 'socials_url' => 'https://instagram.com/teste']
            ],
            'prices' => [
                ['prices_title' => 'Ingresso', 'prices_price' => 50]
            ],
            'times' => [
                'segunda' => ['08:00-18:00'],
                'terca' => ['08:00-18:00']
            ],
            'commodities' => [1,2],
            'discounts' => [1],
            'ages' => [3,4],
            'cep' => '12345678',
            'streetnum' => '1234',
            'city' => 'São Paulo',
            'neighborhood' => 'Centro',
            'plus' => '',
            'state' => 'SP',
            'country' => 'Brasil'
        ];

        $ch = curl_init($this->playUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $sessionId);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(201, $decoded['status']);
        $this->assertStringContainsString('Brinquedo criado com sucesso', $decoded['message']);
    }

    public function testEmpPostWithoutSession()
    {
        $data = [
            'description' => str_repeat('Descrição válida. ', 20),
            'name' => 'Brinquedo Teste ' . rand(1000,9999),
            'cnpj' => '12345678000199',
            'telephone' => '11999999999',
            'email' => 'empresa' . rand(1000,9999) . '@exemplo.com',
            'pictures' => [
                ['picture_name' => 'foto1.jpg']
            ],
            'socials' => [
                ['socials_name' => 'Instagram', 'socials_url' => 'https://instagram.com/teste']
            ],
            'prices' => [
                ['prices_title' => 'Ingresso', 'prices_price' => 50]
            ],
            'times' => [
                'segunda' => ['08:00-18:00']
            ],
            'commodities' => [1],
            'discounts' => [1],
            'ages' => [3],
            'cep' => '12345678',
            'streetnum' => '1234',
            'city' => 'São Paulo',
            'neighborhood' => 'Centro',
            'plus' => '',
            'state' => 'SP',
            'country' => 'Brasil'
        ];

        $ch = curl_init($this->playUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(404, $decoded['status']);
        $this->assertStringContainsString('Cookie não encontrado', $decoded['message']);
    }
}