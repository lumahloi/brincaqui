<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/MinhaClasse.php';

class MinhaClasseTest extends TestCase {
    public function testSoma() {
        $obj = new MinhaClasse();
        $resultado = $obj->somar(2, 3);
        $this->assertEquals(5, $resultado);
    }
}
