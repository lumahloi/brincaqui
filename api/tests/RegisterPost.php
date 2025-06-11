<?php

use PHPUnit\Framework\TestCase;

class RegisterPost extends TestCase
{
    private $url = 'http://localhost/brincaqui/api/auth/register.php';

    public function testRegisterSuccess()
    {
        $data = [
            'fullname' => 'Usuário Teste',
            'userType' => 1,
            'email' => 'usuarioteste' . rand(1000, 9999) . '@exemplo.com',
            'telephone' => '11999999999',
            'password' => 'senhaSegura123',
            'confirmPassword' => 'senhaSegura123'
        ];

        $response = $this->makeRequest($data, 'POST');
        $this->assertEquals(201, $response['status']);
        $this->assertStringContainsString('Conta criada com sucesso', $response['message']);
    }

    public function testRegisterDuplicateEmail()
    {
        $email = 'duplicado' . rand(1000, 9999) . '@exemplo.com';

        // Primeiro cadastro
        $data = [
            'fullname' => 'Usuário Teste',
            'userType' => 1,
            'email' => $email,
            'telephone' => '11999999998',
            'password' => 'senhaSegura123',
            'confirmPassword' => 'senhaSegura123'
        ];
        $this->makeRequest($data, 'POST');

        // Segundo cadastro com o mesmo e-mail
        $response = $this->makeRequest($data, 'POST');
        $this->assertEquals(400, $response['status']);
        $this->assertStringContainsString('Já existe um usuário cadastrado com este e-mail', $response['message']);
    }

    public function testRegisterPasswordMismatch()
    {
        $data = [
            'fullname' => 'Usuário Teste',
            'userType' => 1,
            'email' => 'senhadiferente' . rand(1000, 9999) . '@exemplo.com',
            'telephone' => '11999999997',
            'password' => 'senhaSegura123',
            'confirmPassword' => 'senhaErrada'
        ];

        $response = $this->makeRequest($data, 'POST');
        $this->assertEquals(400, $response['status']);
        $this->assertStringContainsString('As senhas não coincidem', $response['message']);
    }

    public function noBody()
    {
        $data = [];

        $response = $this->makeRequest($data, 'POST');
        $this->assertEquals(400, $response['status']);
    }

    private function makeRequest($data, $method)
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
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