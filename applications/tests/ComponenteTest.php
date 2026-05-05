<?php

use PHPUnit\Framework\TestCase;

class ComponenteTest extends TestCase
{
    private static $testId = null;

    public function testCreate()
    {
        $data = [
            'nome' => 'Componente Test',
            'prezzo' => 99.50,
            'disponibilita' => 20,
        ];
        $result = Componente::crea($data);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('id', $result);
        self::$testId = $result['id'];
    }

    /** @depends testCreate */
    public function testRead()
    {
        $c = Componente::ottieni(self::$testId);
        $this->assertNotNull($c);
        $this->assertEquals('Componente Test', $c->nome);
        $this->assertEquals(99.50, (float)$c->prezzo);
        $this->assertEquals(20, (int)$c->disponibilita);
    }

    /** @depends testRead */
    public function testUpdate()
    {
        $data = [
            'nome' => 'Componente Modificato',
            'prezzo' => 149.00,
            'disponibilita' => 15,
        ];
        $result = Componente::modifica(self::$testId, $data);
        $this->assertArrayHasKey('success', $result);

        $c = Componente::ottieni(self::$testId);
        $this->assertEquals('Componente Modificato', $c->nome);
        $this->assertEquals(149.00, (float)$c->prezzo);
        $this->assertEquals(15, (int)$c->disponibilita);
    }

    /** @depends testUpdate */
    public function testSetDisponibilita()
    {
        $result = Componente::impostaDisponibilita(self::$testId, 5);
        $this->assertArrayHasKey('success', $result);
        $c = Componente::ottieni(self::$testId);
        $this->assertEquals(5, (int)$c->disponibilita);
    }

    /** @depends testSetDisponibilita */
    public function testSetDisponibilitaZero()
    {
        Componente::impostaDisponibilita(self::$testId, 0);
        $c = Componente::ottieni(self::$testId);
        $this->assertEquals(0, (int)$c->disponibilita);
    }

    /** @depends testSetDisponibilitaZero */
    public function testSearch()
    {
        $results = Componente::cerca('Componente');
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    /** @depends testSearch */
    public function testGetAll()
    {
        $all = Componente::tutti();
        $this->assertGreaterThanOrEqual(1, count($all));
    }

    /** @depends testGetAll */
    public function testConta()
    {
        $count = Componente::conta();
        $this->assertGreaterThanOrEqual(1, $count);
    }

    /** @depends testConta */
    public function testDelete()
    {
        $result = Componente::cancella(self::$testId);
        $this->assertArrayHasKey('success', $result);
        $c = Componente::ottieni(self::$testId);
        $this->assertNull($c);
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$testId) Componente::cancella(self::$testId);
    }
}
