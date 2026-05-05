<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

class Fattura extends Model
{
    protected $table = 'FATTTURA';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function crea($dati)
    {
        if (!isset($dati['dispositivo_id']) || (int)$dati['dispositivo_id'] <= 0) {
            return ['error' => 'Dispositivo non valido.'];
        }
        if (!isset($dati['dipendente_id']) || (int)$dati['dipendente_id'] <= 0) {
            return ['error' => 'Dipendente non valido.'];
        }
        if (!isset($dati['ore_lavoro']) || (float)$dati['ore_lavoro'] <= 0) {
            return ['error' => 'Le ore di lavoro devono essere maggiori di zero.'];
        }

        $prezzo = isset($dati['prezzo']) ? (float)$dati['prezzo'] : 0;
        $descrizione = isset($dati['descrizione']) ? Auth::sanitize($dati['descrizione']) : '';
        $oreLavoro = (float)$dati['ore_lavoro'];

        $fatturaId = Capsule::table('FATTTURA')->insertGetId([
            'prezzo' => $prezzo,
            'descrizione' => $descrizione,
            'ore_lavoro' => $oreLavoro,
        ]);

        Capsule::table('riferisce')->insert([
            'dispositivo_id' => (int)$dati['dispositivo_id'],
            'fattura_id' => $fatturaId,
        ]);

        Capsule::table('Crea')->insert([
            'fattura_id' => $fatturaId,
            'dipendente_id' => (int)$dati['dipendente_id'],
        ]);

        if (!empty($dati['componenti'])) {
            foreach ($dati['componenti'] as $compId) {
                $qty = isset($dati['quantita'][$compId]) ? (int)$dati['quantita'][$compId] : 1;
                Capsule::table('usa')->insert([
                    'fattura_id' => $fatturaId,
                    'componente_id' => $compId,
                    'quantita' => $qty,
                ]);
                Capsule::table('COMPONENTE')
                    ->where('id', $compId)
                    ->where('disponibilita', '>', 0)
                    ->decrement('disponibilita', $qty);
            }
        }

        return ['success' => 'Fattura creata con successo.', 'id' => $fatturaId];
    }

    public static function ottieni($id)
    {
        $fattura = self::find($id);
        if (!$fattura) return null;

        $data = $fattura->toArray();

        $disp = Capsule::table('riferisce')
            ->join('DISPOSITIVO', 'riferisce.dispositivo_id', '=', 'DISPOSITIVO.id')
            ->leftJoin('possiede', 'DISPOSITIVO.id', '=', 'possiede.dispositivo_id')
            ->where('riferisce.fattura_id', $id)
            ->first(['DISPOSITIVO.*', 'possiede.cliente_id']);

        $data['dispositivo'] = $disp ? (array)$disp : null;

        $dip = Capsule::table('Crea')
            ->join('DIPENDENTE', 'Crea.dipendente_id', '=', 'DIPENDENTE.id')
            ->where('Crea.fattura_id', $id)
            ->first(['DIPENDENTE.*']);

        $data['dipendente'] = $dip ? (array)$dip : null;

        $comps = Capsule::table('usa')
            ->join('COMPONENTE', 'usa.componente_id', '=', 'COMPONENTE.id')
            ->where('usa.fattura_id', $id)
            ->get(['COMPONENTE.*', 'usa.quantita']);

        $data['componenti'] = $comps->map(fn($c) => (array)$c)->toArray();

        $data['cliente'] = null;
        if ($disp && isset($disp->cliente_id)) {
            $cli = Capsule::table('CLIENTE')->where('id', $disp->cliente_id)->first();
            $data['cliente'] = $cli ? (array)$cli : null;
        }

        return $data;
    }

    public static function tutte()
    {
        return Capsule::table('FATTTURA')
            ->leftJoin('Crea', 'FATTTURA.id', '=', 'Crea.fattura_id')
            ->leftJoin('DIPENDENTE', 'Crea.dipendente_id', '=', 'DIPENDENTE.id')
            ->leftJoin('riferisce', 'FATTTURA.id', '=', 'riferisce.fattura_id')
            ->leftJoin('DISPOSITIVO', 'riferisce.dispositivo_id', '=', 'DISPOSITIVO.id')
            ->leftJoin('possiede', 'DISPOSITIVO.id', '=', 'possiede.dispositivo_id')
            ->leftJoin('CLIENTE', 'possiede.cliente_id', '=', 'CLIENTE.id')
            ->orderBy('FATTTURA.data_creazione', 'desc')
            ->get([
                'FATTTURA.id', 'FATTTURA.prezzo', 'FATTTURA.descrizione',
                'FATTTURA.ore_lavoro', 'FATTTURA.data_creazione',
                'DIPENDENTE.nome as dipendente_nome',
                'CLIENTE.Nome as cliente_nome', 'CLIENTE.Cognome as cliente_cognome',
                'DISPOSITIVO.nome as dispositivo_nome',
            ])->map(fn($r) => (array)$r)->toArray();
    }

    public static function perCliente($clienteId)
    {
        return Capsule::table('FATTTURA')
            ->join('riferisce', 'FATTTURA.id', '=', 'riferisce.fattura_id')
            ->join('DISPOSITIVO', 'riferisce.dispositivo_id', '=', 'DISPOSITIVO.id')
            ->join('possiede', 'DISPOSITIVO.id', '=', 'possiede.dispositivo_id')
            ->leftJoin('Crea', 'FATTTURA.id', '=', 'Crea.fattura_id')
            ->leftJoin('DIPENDENTE', 'Crea.dipendente_id', '=', 'DIPENDENTE.id')
            ->where('possiede.cliente_id', $clienteId)
            ->orderBy('FATTTURA.data_creazione', 'desc')
            ->get([
                'FATTTURA.id', 'FATTTURA.prezzo', 'FATTTURA.descrizione',
                'FATTTURA.ore_lavoro', 'FATTTURA.data_creazione',
                'DIPENDENTE.nome as dipendente_nome',
                'DISPOSITIVO.nome as dispositivo_nome',
            ])->map(fn($r) => (array)$r)->toArray();
    }

    public static function perDipendente($dipendenteId)
    {
        return Capsule::table('FATTTURA')
            ->join('Crea', 'FATTTURA.id', '=', 'Crea.fattura_id')
            ->leftJoin('riferisce', 'FATTTURA.id', '=', 'riferisce.fattura_id')
            ->leftJoin('DISPOSITIVO', 'riferisce.dispositivo_id', '=', 'DISPOSITIVO.id')
            ->leftJoin('possiede', 'DISPOSITIVO.id', '=', 'possiede.dispositivo_id')
            ->leftJoin('CLIENTE', 'possiede.cliente_id', '=', 'CLIENTE.id')
            ->where('Crea.dipendente_id', $dipendenteId)
            ->orderBy('FATTTURA.data_creazione', 'desc')
            ->get([
                'FATTTURA.id', 'FATTTURA.prezzo', 'FATTTURA.descrizione',
                'FATTTURA.ore_lavoro', 'FATTTURA.data_creazione',
                'CLIENTE.Nome as cliente_nome', 'CLIENTE.Cognome as cliente_cognome',
                'DISPOSITIVO.nome as dispositivo_nome',
            ])->map(fn($r) => (array)$r)->toArray();
    }

    public static function calcolaPrezzo($ore, $salarioOrario, $componentiIds = [], $quantita = [])
    {
        $totale = (float)$ore * (float)$salarioOrario;

        if (!empty($componentiIds)) {
            foreach ($componentiIds as $compId) {
                $comp = Capsule::table('COMPONENTE')->where('id', $compId)->first();
                if ($comp) {
                    $qty = isset($quantita[$compId]) ? (int)$quantita[$compId] : 1;
                    $totale += (float)$comp->prezzo * $qty;
                }
            }
        }

        return $totale;
    }

    public static function conta()
    {
        return self::query()->count();
    }

    public static function ricaviTotali()
    {
        return (float)Capsule::table('FATTTURA')->sum('prezzo');
    }
}
