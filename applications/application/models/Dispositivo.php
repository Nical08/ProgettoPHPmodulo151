<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

class Dispositivo extends Model
{
    protected $table = 'DISPOSITIVO';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        'Prezzo_nuovo' => 'float',
    ];

    public function clienti()
    {
        return $this->belongsToMany(Cliente::class, 'possiede', 'dispositivo_id', 'cliente_id');
    }

    public function categorie()
    {
        return $this->belongsToMany(Categoria::class, 'appartiene', 'dispositivo_id', 'nome_categoria');
    }

    public static function crea($dati)
    {
        if (empty($dati['nome'])) {
            return ['error' => 'Il nome è obbligatorio.'];
        }

        $d = new self();
        $d->nome = Auth::sanitize($dati['nome']);
        $d->Modello = isset($dati['modello']) ? Auth::sanitize($dati['modello']) : '';
        $d->note_caratteristiche = isset($dati['note']) ? Auth::sanitize($dati['note']) : '';
        $d->Prezzo_nuovo = isset($dati['prezzo_nuovo']) ? (float)$dati['prezzo_nuovo'] : 0;
        $d->Data_acquisto = $dati['data_acquisto'] ?? null;
        $d->Data_produzione = $dati['data_produzione'] ?? null;
        $d->save();

        return ['success' => 'Dispositivo creato con successo.', 'id' => $d->id];
    }

    public static function modifica($id, $dati)
    {
        if (empty($dati['nome'])) {
            return ['error' => 'Il nome è obbligatorio.'];
        }

        $d = self::find($id);
        if (!$d) {
            return ['error' => 'Dispositivo non trovato.'];
        }

        $d->nome = Auth::sanitize($dati['nome']);
        $d->Modello = isset($dati['modello']) ? Auth::sanitize($dati['modello']) : '';
        $d->note_caratteristiche = isset($dati['note']) ? Auth::sanitize($dati['note']) : '';
        $d->Prezzo_nuovo = isset($dati['prezzo_nuovo']) ? (float)$dati['prezzo_nuovo'] : 0;
        $d->Data_acquisto = $dati['data_acquisto'] ?? null;
        $d->Data_produzione = $dati['data_produzione'] ?? null;
        $d->save();

        return ['success' => 'Dispositivo modificato con successo.', 'id' => $d->id];
    }

    public static function cancella($id)
    {
        $deleted = self::destroy($id);
        if ($deleted === 0) return ['error' => 'Dispositivo non trovato.'];
        return ['success' => 'Dispositivo eliminato con successo.', 'id' => $id];
    }

    public static function ottieni($id)
    {
        return self::find($id);
    }

    public static function tutti()
    {
        return self::orderBy('nome', 'asc')->get();
    }

    public static function cerca($termine)
    {
        $t = '%' . Auth::sanitize($termine) . '%';
        return self::where('nome', 'like', $t)
            ->orWhere('Modello', 'like', $t)
            ->orderBy('nome', 'asc')
            ->get();
    }

    public static function perCliente($clienteId)
    {
        return self::whereIn('id', function ($q) use ($clienteId) {
            $q->select('dispositivo_id')->from('possiede')->where('cliente_id', $clienteId);
        })->get();
    }

    public static function assegnaCliente($dispositivoId, $clienteId)
    {
        Capsule::table('possiede')->insert([
            'cliente_id' => $clienteId,
            'dispositivo_id' => $dispositivoId,
        ]);

        return ['success' => 'Cliente assegnato al dispositivo con successo.'];
    }

    public static function impostaCategoria($dispositivoId, $categoriaNome)
    {
        Capsule::table('appartiene')->where('dispositivo_id', $dispositivoId)->delete();
        Capsule::table('appartiene')->insert([
            'dispositivo_id' => $dispositivoId,
            'nome_categoria' => $categoriaNome,
        ]);

        return ['success' => 'Categoria impostata con successo.'];
    }

    public static function ottieniCategorie($dispositivoId)
    {
        return Capsule::table('appartiene')
            ->join('Categoria', 'appartiene.nome_categoria', '=', 'Categoria.nome_categoria')
            ->where('appartiene.dispositivo_id', $dispositivoId)
            ->get(['Categoria.*']);
    }

    public static function conta()
    {
        return self::query()->count();
    }
}
