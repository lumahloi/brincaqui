<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $url = 'http://localhost/brincaqui/api/auth/login.php';

    public function testLoginSuccess()
    {
        $data = [
            'email' => 'lumahcliente@gmail.com', // Use um usuário válido existente no banco
            'password' => 'admin@123'
        ];

        $response = $this->makeRequest($data);
        $this->assertEquals(200, $response['status']);
        $this->assertArrayHasKey('logged_user_id', $response['data']);
        $this->assertArrayHasKey('logged_session_id', $response['data']);
    }

    public function testLoginWrongPassword()
    {
        $data = [
            'email' => 'lumahcliente@gmail.com',
            'password' => 'senha_errada'
        ];

        $response = $this->makeRequest($data);
        $this->assertEquals(400, $response['status']);
        $this->assertStringContainsString('Senha inválida', $response['message']);
    }

    public function testLoginNonexistentUser()
    {
        $data = [
            'email' => 'naoexiste@teste.com',
            'password' => 'qualquercoisa'
        ];

        $response = $this->makeRequest($data);
        $this->assertEquals(400, $response['status']);
    }

    private function makeRequest($data)
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);
        return [
            'status' => $decoded['status'] ?? null,
            'message' => $decoded['message'] ?? '',
            'data' => $decoded['data'] ?? []
        ];
    }
}