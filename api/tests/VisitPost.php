<?php

use PHPUnit\Framework\TestCase;

class VisitPost extends TestCase
{
    private $loginUrl = 'http://localhost/brincaqui/api/auth/login.php';
    private $visitUrl = 'http://localhost/brincaqui/api/visit/'; // Exemplo: /visit/{id}

    private function loginAndGetSessionCookie()
    {
        $loginData = [
            'email' => 'lumahcliente@gmail.com', // Use um usuário válido do tipo cliente
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

    public function testVisitPostSuccess()
    {
        $sessionId = $this->loginAndGetSessionCookie();
        $this->assertNotEmpty($sessionId, 'Sessão não criada no login.');

        $brinquedoId = 1; // Use um ID de brinquedo válido para o teste

        $ch = curl_init($this->visitUrl . $brinquedoId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $sessionId);

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(201, $decoded['status']);
        $this->assertStringContainsString('Visita marcada com sucesso', $decoded['message']);
    }

    public function testVisitPostWithoutSession()
    {
        $brinquedoId = 1; // Use um ID de brinquedo válido para o teste

        $ch = curl_init($this->visitUrl . $brinquedoId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(404, $decoded['status']);
        $this->assertStringContainsString('Cookie não encontrado', $decoded['message']);
    }

    public function testVisitPostWithoutToyId()
    {
        $sessionId = $this->loginAndGetSessionCookie();
        $this->assertNotEmpty($sessionId, 'Sessão não criada no login.');

        // Não informar o ID do brinquedo na URL
        $ch = curl_init($this->visitUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
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