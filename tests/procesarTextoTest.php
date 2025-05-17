<?php
// tests/ProcesadorTextoTest.php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload clases

class ProcesadorTextoTest extends TestCase
{
    private array $sw;

   public function test_quitarTildes(): void
{
    $p = new ProcesadorTexto(['de','la','y','el']);
    $this->assertEquals('arbol', $p->quitarTildes('árbol'));
    $this->assertEquals('senor', $p->quitarTildes('señor'));
}

public function test_normalizar(): void
{
    $p = new ProcesadorTexto(['de','la','y','el']);
    $this->assertEquals('hola mundo', $p->normalizar('HOLA MUNDO'));
}

public function test_limpiar(): void
{
    $p = new ProcesadorTexto(['de','la','y','el']);
    $res = $p->limpiar('Hola, mundo!123');
    $this->assertStringNotContainsString('1', $res);
    $this->assertStringNotContainsString(',', $res);
    $this->assertStringContainsString('Hola', $res);
}

public function test_tokenizar(): void
{
    $p = new ProcesadorTexto(['de','la','y','el']);
    $this->assertSame(
        ['uno','dos','tres'],
        $p->tokenizar('uno  dos   tres')
    );
}

}
