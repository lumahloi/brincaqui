<?php

use PHPUnit\Framework\TestCase;

class FeedbackUserAll extends TestCase
{
    private $urlBase = 'http://localhost/brincaqui/api/feedback/';
    
    public function testUserAllSuccess()
    {
        $brinquedoId = 1; // Use um ID de brinquedo válido com avaliações cadastradas

        $url = $this->urlBase . $brinquedoId;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(200, $decoded['status']);
        $this->assertStringContainsString('Informações extraídas com sucesso', $decoded['message']);
        $this->assertIsArray($decoded['data']);
    }

    public function testUserAllWithoutToyId()
    {
        $url = $this->urlBase; // Sem o ID do brinquedo
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $decoded = json_decode($result, true);

        $this->assertEquals(400, $decoded['status']);
        $this->assertStringContainsString('ID do brinquedo não especificado', $decoded['message']);
    }
}