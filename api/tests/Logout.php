<?php
use PHPUnit\Framework\TestCase;

class Logout extends TestCase
{
    private $url = 'http://localhost/brincaqui/api/auth/logout.php';

    public function testLogoutSuccess()
    {
        // Primeiro, faça login para obter um cookie de sessão válido
        $loginUrl = 'http://localhost/brincaqui/api/auth/login.php';
        $loginData = [
            'email' => 'lumahcliente@gmail.com', // Use um usuário válido
            'password' => 'admin@123'
        ];

        $ch = curl_init($loginUrl);
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
        $body = substr($response, $header_size);

        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches);
        $cookies = [];
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        curl_close($ch);

        $this->assertNotEmpty($cookies['PHPSESSID'] ?? null, 'Sessão não criada no login.');

        // Agora, faça logout usando o cookie de sessão
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $cookies['PHPSESSID']);

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(200, $decoded['status']);
        $this->assertStringContainsString('Até mais', $decoded['message']);
    }

    public function testLogoutWrongMethod()
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(405, $decoded['status']);
        $this->assertStringContainsString('Apenas POST permitido', $decoded['message']);
    }
}