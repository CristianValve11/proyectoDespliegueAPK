<?php
// tests/ProcesadorTextoTest.php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload clases

class ProcesadorTextoTest extends TestCase
{
    private array $sw;

    protected function setUp(): void
    {
        $this->sw = ['de','la','y','el'];
    }

    public function test_quitarTildes(): void
    {
        $p = new ProcesadorTexto($this->sw);
        $this->assertEquals('arbol', $p->quitarTildes('árbol'));
    }

    public function test_normalizar(): void
    {
        $p = new ProcesadorTexto($this->sw);
        $this->assertEquals('hola', $p->normalizar('HOLA'));
    }

    public function test_limpiar(): void
    {
        $p = new ProcesadorTexto($this->sw);
        $res = $p->limpiar('Hola, mundo!123');
        $this->assertStringNotContainsString('1', $res);
        $this->assertStringNotContainsString('2', $res);
        $this->assertStringNotContainsString(',', $res);
        $this->assertStringNotContainsString('!', $res);
        $this->assertStringContainsString('Hola', $res);
    }

    public function test_tokenizar(): void
    {
        $p = new ProcesadorTexto($this->sw);
        $this->assertSame(['uno','dos','tres'], $p->tokenizar('uno  dos tres'));
    }

    public function test_filtrar(): void
    {
        $p = new ProcesadorTexto($this->sw);
        $this->assertSame(
            ['casa','arbol'],
            $p->filtrar(['de','casa','la','árbol'])
        );
    }

    public function test_contar(): void
    {
        $p = new ProcesadorTexto($this->sw);
        $this->assertSame(
            ['hola'=>2,'mundo'=>1],
            $p->contar(['hola','mundo','hola'])
        );
    }

    /**
     * @depends test_quitarTildes
     * @depends test_filtrar
     */
    public function test_pipelineCompleto(): void
    {
        $p = new ProcesadorTexto($this->sw);
        $freq = $p->procesar('¡Árbol, árbol! de la ÁRBOL.');
        $this->assertEquals(3, $freq['arbol']);
    }
}
