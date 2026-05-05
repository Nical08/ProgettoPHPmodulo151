<?php

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

class FatturaTest extends TestCase
{
    private static $testFatturaId = null;
    private static $testDispositivoId = null;
    private static $testClienteId = null;
    private static $testDipendenteId = null;

    public static function setUpBeforeClass(): void
    {
        $clienteEmail = 'fatt_test_cliente_' . time() . '@test.com';
        $r = Cliente::crea([
            'Nome' => 'Fattura', 'Cognome' => 'Test Cliente',
            'Email' => $clienteEmail, 'password' => 'test123',
        ]);
        self::$testClienteId = $r['id'];

        $dipEmail = 'fatt_test_dip_' . time() . '@test.com';
        $r = Dipendente::crea([
            'nome' => 'Fattura Test Dip', 'salario_orario' => 40.00,
            'email' => $dipEmail, 'password' => 'test123', 'ruolo' => 'dipendente',
        ]);
        self::$testDipendenteId = $r['id'];

        $r = Dispositivo::crea([
            'nome' => 'Fattura Test Device', 'modello' => 'FT-100',
            'prezzo_nuovo' => 500.00, 'data_acquisto' => '2025-01-01',
        ]);
        self::$testDispositivoId = $r['id'];

        Dispositivo::assegnaCliente(self::$testDispositivoId, self::$testClienteId);
    }

    public function testCalculatePrezzoSoloManoOpera()
    {
        $prezzo = Fattura::calcolaPrezzo(10, 40.00, [], []);
        $this->assertEquals(400.00, $prezzo);
    }

    public function testCalculatePrezzoManoOperaZero()
    {
        $prezzo = Fattura::calcolaPrezzo(0, 40.00, [], []);
        $this->assertEquals(0.00, $prezzo);
    }

    public function testCalculatePrezzoConComponenti()
    {
        $componenti = Componente::tutti();
        if (count($componenti) >= 2) {
            $compIds = [$componenti[0]->id, $componenti[1]->id];
            $quantita = [$componenti[0]->id => 2, $componenti[1]->id => 1];
            $expected = (5 * 40.00) + ($componenti[0]->prezzo * 2) + ($componenti[1]->prezzo * 1);
            $prezzo = Fattura::calcolaPrezzo(5, 40.00, $compIds, $quantita);
            $this->assertEquals($expected, $prezzo);
        }
        $this->assertTrue(true);
    }

    public function testCreateFatturaSoloManoOpera()
    {
        $dipendente = Dipendente::ottieni(self::$testDipendenteId);
        $ore = 10;
        $prezzo = Fattura::calcolaPrezzo($ore, $dipendente->salario_orario, [], []);

        $data = [
            'prezzo' => $prezzo,
            'descrizione' => 'Riparazione test',
            'ore_lavoro' => $ore,
            'dispositivo_id' => self::$testDispositivoId,
            'dipendente_id' => self::$testDipendenteId,
            'componenti' => [],
            'quantita' => [],
        ];

        $result = Fattura::crea($data);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('id', $result);
        self::$testFatturaId = $result['id'];
    }

    /** @depends testCreateFatturaSoloManoOpera */
    public function testReadFattura()
    {
        $fattura = Fattura::ottieni(self::$testFatturaId);
        $this->assertNotNull($fattura);
        $this->assertEquals(400.00, (float)$fattura['prezzo']);
        $this->assertEquals(10, (float)$fattura['ore_lavoro']);
        $this->assertEquals('Riparazione test', $fattura['descrizione']);
        $this->assertNotNull($fattura['dispositivo']);
        $this->assertNotNull($fattura['dipendente']);
        $this->assertNotNull($fattura['cliente']);
    }

    /** @depends testReadFattura */
    public function testGetByCliente()
    {
        $fatture = Fattura::perCliente(self::$testClienteId);
        $this->assertGreaterThanOrEqual(1, count($fatture));
        $found = false;
        foreach ($fatture as $f) {
            if ($f['id'] == self::$testFatturaId) { $found = true; break; }
        }
        $this->assertTrue($found);
    }

    /** @depends testGetByCliente */
    public function testGetByDipendente()
    {
        $fatture = Fattura::perDipendente(self::$testDipendenteId);
        $this->assertGreaterThanOrEqual(1, count($fatture));
        $found = false;
        foreach ($fatture as $f) {
            if ($f['id'] == self::$testFatturaId) { $found = true; break; }
        }
        $this->assertTrue($found);
    }

    /** @depends testGetByDipendente */
    public function testGetAll()
    {
        $all = Fattura::tutte();
        $this->assertGreaterThanOrEqual(1, count($all));
    }

    /** @depends testGetAll */
    public function testConta()
    {
        $count = Fattura::conta();
        $this->assertGreaterThanOrEqual(1, $count);
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$testFatturaId) {
            Capsule::table('usa')->where('fattura_id', self::$testFatturaId)->delete();
            Capsule::table('Crea')->where('fattura_id', self::$testFatturaId)->delete();
            Capsule::table('riferisce')->where('fattura_id', self::$testFatturaId)->delete();
            Capsule::table('FATTTURA')->where('id', self::$testFatturaId)->delete();
        }
        if (self::$testDispositivoId) Dispositivo::cancella(self::$testDispositivoId);
        if (self::$testClienteId) Cliente::cancella(self::$testClienteId);
        if (self::$testDipendenteId) Dipendente::cancella(self::$testDipendenteId);
    }
}
