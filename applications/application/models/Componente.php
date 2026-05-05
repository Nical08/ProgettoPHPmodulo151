<?php

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    protected $table = 'COMPONENTE';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function crea($dati)
    {
        $nome = Auth::sanitize($dati['nome'] ?? '');
        $prezzo = (float)($dati['prezzo'] ?? 0);
        $disp = (int)($dati['disponibilita'] ?? 0);

        if (empty($nome)) return ['error' => 'Il nome è obbligatorio.'];
        if ($prezzo <= 0) return ['error' => 'Il prezzo deve essere maggiore di 0.'];

        $c = new self();
        $c->nome = $nome;
        $c->prezzo = $prezzo;
        $c->disponibilita = $disp;
        $c->save();

        return ['success' => 'Componente creato con successo.', 'id' => $c->id];
    }

    public static function modifica($id, $dati)
    {
        $c = self::find($id);
        if (!$c) return ['error' => 'Componente non trovato.'];

        $nome = Auth::sanitize($dati['nome'] ?? '');
        $prezzo = (float)($dati['prezzo'] ?? 0);
        $disp = (int)($dati['disponibilita'] ?? 0);

        if (empty($nome)) return ['error' => 'Il nome è obbligatorio.'];
        if ($prezzo <= 0) return ['error' => 'Il prezzo deve essere maggiore di 0.'];

        $c->nome = $nome;
        $c->prezzo = $prezzo;
        $c->disponibilita = $disp;
        $c->save();

        return ['success' => 'Componente modificato con successo.', 'id' => $c->id];
    }

    public static function cancella($id)
    {
        $deleted = self::destroy($id);
        if ($deleted === 0) return ['error' => 'Componente non trovato.'];
        return ['success' => 'Componente eliminato con successo.', 'id' => $id];
    }

    public static function ottieni($id) { return self::find($id); }
    public static function tutti() { return self::orderBy('nome', 'asc')->get(); }

    public static function cerca($termine)
    {
        $t = '%' . $termine . '%';
        return self::where('nome', 'like', $t)->orderBy('nome', 'asc')->get();
    }

    public static function impostaDisponibilita($id, $qty)
    {
        $c = self::find($id);
        if (!$c) return ['error' => 'Componente non trovato.'];
        $c->disponibilita = (int)$qty;
        $c->save();
        return ['success' => 'Disponibilità aggiornata.', 'id' => $c->id];
    }

    public static function conta() { return self::query()->count(); }
}
