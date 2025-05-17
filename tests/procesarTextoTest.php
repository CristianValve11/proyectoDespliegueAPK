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

}
