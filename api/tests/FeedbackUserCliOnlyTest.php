<?php

use PHPUnit\Framework\TestCase;

class FeedbackUserCliOnlyTest extends TestCase
{
    private $loginUrl = 'http://localhost/brincaqui/api/auth/login.php';
    private $feedbackUrl = 'http://localhost/brincaqui/api/feedback/'; // Exemplo: /feedback/{id}

    private function loginAndGetSessionCookie()
    {
        $loginData = [
            'email' => 'lumahcliente@gmail.com', // Use um usuário válido de teste
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

    public function testFeedbackUserCliOnlySuccess()
    {
        $sessionId = $this->loginAndGetSessionCookie();
        $this->assertNotEmpty($sessionId, 'Sessão não criada no login.');

        $brinquedoId = 1; // Use um ID de brinquedo válido para o teste

        $data = [
            'description' => str_repeat('Ótimo brinquedo! ', 10), // >= 100 caracteres
            'grade_1' => 5,
            'grade_2' => 4,
            'grade_3' => 5,
            'grade_4' => 4,
            'grade_5' => 5,
            'grade_6' => 4
        ];

        $ch = curl_init($this->feedbackUrl . $brinquedoId);
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
        $this->assertStringContainsString('Brinquedo avaliado com sucesso', $decoded['message']);
    }

    public function testFeedbackUserCliOnlyWithoutSession()
    {
        $brinquedoId = 1; // Use um ID de brinquedo válido para o teste

        $data = [
            'description' => str_repeat('Ótimo brinquedo! ', 10),
            'grade_1' => 5,
            'grade_2' => 4,
            'grade_3' => 5,
            'grade_4' => 4,
            'grade_5' => 5,
            'grade_6' => 4
        ];

        $ch = curl_init($this->feedbackUrl . $brinquedoId);
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

    public function testFeedbackUserCliOnlyWithoutToyId()
    {
        $sessionId = $this->loginAndGetSessionCookie();
        $this->assertNotEmpty($sessionId, 'Sessão não criada no login.');

        $data = [
            'description' => str_repeat('Ótimo brinquedo! ', 10),
            'grade_1' => 5,
            'grade_2' => 4,
            'grade_3' => 5,
            'grade_4' => 4,
            'grade_5' => 5,
            'grade_6' => 4
        ];

        // Não informar o ID do brinquedo na URL
        $ch = curl_init($this->feedbackUrl);
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

        $this->assertEquals(400, $decoded['status']);
        $this->assertStringContainsString('ID do brinquedo não especificado', $decoded['message']);
    }
}