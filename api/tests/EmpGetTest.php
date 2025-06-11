<?php
<?php
use PHPUnit\Framework\TestCase;

class EmpGetTest extends TestCase
{
    private $loginUrl = 'http://localhost/brincaqui/api/auth/login.php';
    private $playUrl = 'http://localhost/brincaqui/api/play/1'; // O ID é necessário para acessar user_empresa.php

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

    public function testEmpGetSuccess()
    {
        $sessionId = $this->loginAndGetSessionCookie();
        $this->assertNotEmpty($sessionId, 'Sessão não criada no login.');

        $ch = curl_init($this->playUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $sessionId);

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(200, $decoded['status']);
        $this->assertStringContainsString('Informações extraídas com sucesso', $decoded['message']);
        $this->assertIsArray($decoded['data']);
    }

    public function testEmpGetWithoutSession()
    {
        $ch = curl_init($this->playUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(404, $decoded['status']);
        $this->assertStringContainsString('Cookie não encontrado', $decoded['message']);
    }

    public function testEmpGetWithoutToyId()
    {
        $sessionId = $this->loginAndGetSessionCookie();
        $this->assertNotEmpty($sessionId, 'Sessão não criada no login.');

        // Não informar o ID do brinquedo na URL
        $url = 'http://localhost/brincaqui/api/play/';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $sessionId);

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(400, $decoded['status']);
        $this->assertStringContainsString('ID do brinquedo não especificado', $decoded['message']);
    }
}