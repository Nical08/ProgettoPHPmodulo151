<?php

use PHPUnit\Framework\TestCase;

class ClienteTest extends TestCase
{
    private static $testId = null;
    private static $testEmail = null;

    public static function setUpBeforeClass(): void
    {
        self::$testEmail = 'test_cliente_' . time() . '_' . rand(100, 999) . '@test.com';
    }

    public function testCreate()
    {
        $data = [
            'Nome' => 'Test',
            'Cognome' => 'Cliente',
            'Indirizzo' => 'Via Test 123',
            'Email' => self::$testEmail,
            'Telefono' => '0911111111',
            'password' => 'testpass123',
        ];
        $result = Cliente::crea($data);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('id', $result);
        self::$testId = $result['id'];
    }

    /** @depends testCreate */
    public function testRead()
    {
        $cliente = Cliente::ottieni(self::$testId);
        $this->assertNotNull($cliente);
        $this->assertEquals('Test', $cliente->Nome);
        $this->assertEquals('Cliente', $cliente->Cognome);
        $this->assertEquals(self::$testEmail, $cliente->Email);
    }

    /** @depends testRead */
    public function testUpdate()
    {
        $data = [
            'Nome' => 'TestAggiornato',
            'Cognome' => 'ClienteAggiornato',
            'Indirizzo' => 'Via Nuova 456',
            'Email' => self::$testEmail,
            'Telefono' => '0912222222',
            'password' => '',
        ];
        $result = Cliente::modifica(self::$testId, $data);
        $this->assertArrayHasKey('success', $result);

        $cliente = Cliente::ottieni(self::$testId);
        $this->assertEquals('TestAggiornato', $cliente->Nome);
        $this->assertEquals('ClienteAggiornato', $cliente->Cognome);
    }

    /** @depends testUpdate */
    public function testUpdateWithPassword()
    {
        $data = [
            'Nome' => 'TestAggiornato',
            'Cognome' => 'ClienteAggiornato',
            'Indirizzo' => '',
            'Email' => self::$testEmail,
            'Telefono' => '',
            'password' => 'nuovapassword',
        ];
        $result = Cliente::modifica(self::$testId, $data);
        $this->assertArrayHasKey('success', $result);

        $loginResult = Auth::login(self::$testEmail, 'nuovapassword');
        $this->assertEquals('cliente', $loginResult);
        Auth::logout();
    }

    /** @depends testUpdate */
    public function testSearch()
    {
        $results = Cliente::cerca('TestAggiornato');
        $this->assertGreaterThanOrEqual(1, count($results));
        $found = false;
        foreach ($results as $c) {
            if ($c->id == self::$testId) { $found = true; break; }
        }
        $this->assertTrue($found);
    }

    /** @depends testSearch */
    public function testGetAll()
    {
        $all = Cliente::tutti();
        $this->assertGreaterThanOrEqual(1, count($all));
    }

    /** @depends testGetAll */
    public function testConta()
    {
        $count = Cliente::conta();
        $this->assertGreaterThanOrEqual(1, $count);
    }

    /** @depends testConta */
    public function testDelete()
    {
        $result = Cliente::cancella(self::$testId);
        $this->assertArrayHasKey('success', $result);

        $cliente = Cliente::ottieni(self::$testId);
        $this->assertNull($cliente);
    }

    public function testCreateDuplicateEmail()
    {
        $this->expectException(\Exception::class);
        $data1 = [
            'Nome' => 'Primo', 'Cognome' => 'Utente',
            'Email' => 'duplicato_test@test.com', 'password' => 'pass123',
        ];
        Cliente::crea($data1);
        $data2 = [
            'Nome' => 'Secondo', 'Cognome' => 'Utente',
            'Email' => 'duplicato_test@test.com', 'password' => 'pass456',
        ];
        Cliente::crea($data2);
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$testId) Cliente::cancella(self::$testId);
    }
}
