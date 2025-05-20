<?php
// tests/procesarTextoTest.php

use PHPUnit\Framework\TestCase;
// Cargo la clase y el endpoint REST
require_once __DIR__ . '/../backend/procesar.php';

class ProcesadorTextoTest extends TestCase
{
    private array $sw;

    protected function setUp(): void
    {
        // Defino mis stop words en minusculas
        $this->sw = ['de','la','y','el'];
    }

    public function test_quitarTildes(): void
    {
        // Probar metodo que quita tildes
        $p = $this->getMockBuilder(ProcesadorTexto::class)
                  ->disableOriginalConstructor()
                  ->onlyMethods([])
                  ->getMock();
        $this->assertEquals('arbol', $p->quitarTildes('árbol'));  
        $this->assertEquals('senor', $p->quitarTildes('señor'));
    }

    public function test_normalizar(): void
    {
        // Probar minusculas UTF-8
        $p = $this->getMockBuilder(ProcesadorTexto::class)
                  ->disableOriginalConstructor()
                  ->onlyMethods([])
                  ->getMock();
        $this->assertEquals('hola mundo', $p->normalizar('HOLA MUNDO'));
    }

    public function test_limpiar(): void
    {
        // Probar que elimina caracteres no-letra
        $p = $this->getMockBuilder(ProcesadorTexto::class)
                  ->disableOriginalConstructor()
                  ->onlyMethods([])
                  ->getMock();
        $resultado = $p->limpiar('Hola, mundo? 123!');
        $this->assertStringNotContainsString('1', $resultado);
        $this->assertStringNotContainsString(',', $resultado);
        $this->assertStringNotContainsString('?', $resultado);
        $this->assertStringContainsString('Hola', $resultado);
    }

    public function test_tokenizar(): void
    {
        // Probar tokenizacion
        $p = $this->getMockBuilder(ProcesadorTexto::class)
                  ->disableOriginalConstructor()
                  ->onlyMethods([])
                  ->getMock();
        $this->assertSame(
            ['uno','dos','tres'],
            $p->tokenizar('uno  dos   tres')
        );
    }

    public function test_filtrar(): void
    {
        // Mock para aislar filtrar y simular quitarTildes y normalizar reales
        $tokens = ['de','casa','la','árbol'];
        $numCalls = count($tokens);

        $p = $this->getMockBuilder(ProcesadorTexto::class)
                  ->setConstructorArgs([$this->sw])
                  ->onlyMethods(['quitarTildes','normalizar'])
                  ->getMock();

        // Simulo quitarTildes reemplazando acentos
        $p->expects($this->exactly($numCalls))
          ->method('quitarTildes')
          ->willReturnCallback(function($t) {
              // reemplazo acentos simple
              return strtr($t, ['Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U','á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','Ñ'=>'N','ñ'=>'n']);
          });

        // Simulo normalizar a minusculas
        $p->expects($this->exactly($numCalls))
          ->method('normalizar')
          ->willReturnCallback(fn($t) => mb_strtolower($t,'UTF-8'));

        $esperado = ['casa','arbol'];
        $this->assertSame($esperado, $p->filtrar($tokens));
    }

    public function test_contar(): void
    {
        // Probar contador
        $p = $this->getMockBuilder(ProcesadorTexto::class)
                  ->disableOriginalConstructor()
                  ->onlyMethods([])
                  ->getMock();
        $entrada = ['hola','mundo','hola'];
        $esperado = ['hola'=>2,'mundo'=>1];
        $this->assertSame($esperado, $p->contar($entrada));
    }

    public function test_pipelineCompleto(): void
    {
        // Prueba pipeline completo
        $p = new ProcesadorTexto($this->sw);
        $freq = $p->procesar('¡Árbol, árbol! de la ÁRBOL.');
        $this->assertEquals(3, $freq['arbol']);
    }
}
