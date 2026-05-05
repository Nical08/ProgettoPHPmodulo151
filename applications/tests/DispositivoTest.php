<?php

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

class DispositivoTest extends TestCase
{
    private static $testId = null;

    public function testCreate()
    {
        $data = [
            'nome' => 'iPhone Test',
            'modello' => '14 Pro Max',
            'note' => 'Test note',
            'prezzo_nuovo' => 1299.00,
            'data_acquisto' => '2025-01-15',
            'data_produzione' => '2024-12-01',
        ];
        $result = Dispositivo::crea($data);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('id', $result);
        self::$testId = $result['id'];
    }

    /** @depends testCreate */
    public function testRead()
    {
        $d = Dispositivo::ottieni(self::$testId);
        $this->assertNotNull($d);
        $this->assertEquals('iPhone Test', $d->nome);
        $this->assertEquals('14 Pro Max', $d->Modello);
        $this->assertEquals(1299.00, (float)$d->Prezzo_nuovo);
        $this->assertEquals('2025-01-15', $d->Data_acquisto);
        $this->assertEquals('2024-12-01', $d->Data_produzione);
    }

    /** @depends testRead */
    public function testUpdate()
    {
        $data = [
            'nome' => 'Samsung Galaxy Test',
            'modello' => 'S24 Ultra',
            'note' => 'Note aggiornate',
            'prezzo_nuovo' => 1499.00,
            'data_acquisto' => '2025-02-20',
            'data_produzione' => '2025-01-10',
        ];
        $result = Dispositivo::modifica(self::$testId, $data);
        $this->assertArrayHasKey('success', $result);

        $d = Dispositivo::ottieni(self::$testId);
        $this->assertEquals('Samsung Galaxy Test', $d->nome);
        $this->assertEquals(1499.00, (float)$d->Prezzo_nuovo);
    }

    /** @depends testUpdate */
    public function testAssignToCliente()
    {
        $clienti = Cliente::tutti();
        if (count($clienti) > 0) {
            $clienteId = $clienti[0]->id;
            $result = Dispositivo::assegnaCliente(self::$testId, $clienteId);
            $this->assertArrayHasKey('success', $result);

            $dispositiviCliente = Dispositivo::perCliente($clienteId);
            $found = false;
            foreach ($dispositiviCliente as $d) {
                if ($d->id == self::$testId) { $found = true; break; }
            }
            $this->assertTrue($found);
        }
        $this->assertTrue(true);
    }

    /** @depends testAssignToCliente */
    public function testSetCategoria()
    {
        $categorie = Categoria::tutti();
        if (count($categorie) > 0) {
            $catNome = $categorie[0]->nome_categoria;
            $result = Dispositivo::impostaCategoria(self::$testId, $catNome);
            $this->assertArrayHasKey('success', $result);

            $cats = Dispositivo::ottieniCategorie(self::$testId);
            $this->assertGreaterThanOrEqual(1, count($cats));
            $this->assertEquals($catNome, $cats[0]->nome_categoria);
        }
        $this->assertTrue(true);
    }

    /** @depends testSetCategoria */
    public function testSearch()
    {
        $results = Dispositivo::cerca('Samsung');
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    /** @depends testSearch */
    public function testGetAll()
    {
        $all = Dispositivo::tutti();
        $this->assertGreaterThanOrEqual(1, count($all));
    }

    /** @depends testGetAll */
    public function testConta()
    {
        $count = Dispositivo::conta();
        $this->assertGreaterThanOrEqual(1, $count);
    }

    /** @depends testConta */
    public function testDelete()
    {
        $result = Dispositivo::cancella(self::$testId);
        $this->assertArrayHasKey('success', $result);
        $d = Dispositivo::ottieni(self::$testId);
        $this->assertNull($d);
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$testId) Dispositivo::cancella(self::$testId);
    }
}
