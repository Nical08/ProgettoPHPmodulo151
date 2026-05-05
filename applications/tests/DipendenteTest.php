<?php

use PHPUnit\Framework\TestCase;

class DipendenteTest extends TestCase
{
    private static $testId = null;
    private static $testEmail = null;

    public static function setUpBeforeClass(): void
    {
        self::$testEmail = 'test_dip_' . time() . '_' . rand(100, 999) . '@test.com';
    }

    public function testCreate()
    {
        $data = [
            'nome' => 'Test Dipendente',
            'salario_orario' => 35.50,
            'email' => self::$testEmail,
            'password' => 'testpass123',
            'ruolo' => 'dipendente',
        ];
        $result = Dipendente::crea($data);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('id', $result);
        self::$testId = $result['id'];
    }

    /** @depends testCreate */
    public function testRead()
    {
        $d = Dipendente::ottieni(self::$testId);
        $this->assertNotNull($d);
        $this->assertEquals('Test Dipendente', $d->nome);
        $this->assertEquals(35.50, (float)$d->salario_orario);
        $this->assertEquals('dipendente', $d->ruolo);
    }

    /** @depends testRead */
    public function testUpdate()
    {
        $data = [
            'nome' => 'Dipendente Aggiornato',
            'salario_orario' => 40.00,
            'email' => self::$testEmail,
            'password' => '',
            'ruolo' => 'dipendente',
        ];
        $result = Dipendente::modifica(self::$testId, $data);
        $this->assertArrayHasKey('success', $result);

        $d = Dipendente::ottieni(self::$testId);
        $this->assertEquals('Dipendente Aggiornato', $d->nome);
        $this->assertEquals(40.00, (float)$d->salario_orario);
    }

    /** @depends testUpdate */
    public function testUpdateToAdmin()
    {
        $data = [
            'nome' => 'Dipendente Aggiornato',
            'salario_orario' => 40.00,
            'email' => self::$testEmail,
            'password' => '',
            'ruolo' => 'admin',
        ];
        Dipendente::modifica(self::$testId, $data);
        $d = Dipendente::ottieni(self::$testId);
        $this->assertEquals('admin', $d->ruolo);

        $data['ruolo'] = 'dipendente';
        Dipendente::modifica(self::$testId, $data);
    }

    /** @depends testUpdate */
    public function testSearch()
    {
        $results = Dipendente::cerca('Aggiornato');
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    /** @depends testSearch */
    public function testGetAll()
    {
        $all = Dipendente::tutti();
        $this->assertGreaterThanOrEqual(1, count($all));
    }

    /** @depends testGetAll */
    public function testConta()
    {
        $count = Dipendente::conta();
        $this->assertGreaterThanOrEqual(1, $count);
    }

    /** @depends testConta */
    public function testDelete()
    {
        $result = Dipendente::cancella(self::$testId);
        $this->assertArrayHasKey('success', $result);
        $d = Dipendente::ottieni(self::$testId);
        $this->assertNull($d);
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$testId) Dipendente::cancella(self::$testId);
    }
}
