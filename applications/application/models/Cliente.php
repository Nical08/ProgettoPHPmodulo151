<?php

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'CLIENTE';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    private static function nc(&$d, $k)
    {
        return $d[$k] ?? $d[lcfirst($k)] ?? $d[ucfirst($k)] ?? '';
    }

    public function dispositivi()
    {
        return $this->belongsToMany(Dispositivo::class, 'possiede', 'cliente_id', 'dispositivo_id');
    }

    public static function crea($dati)
    {
        $nome = Auth::sanitize(self::nc($dati, 'Nome'));
        $cognome = Auth::sanitize(self::nc($dati, 'Cognome'));
        $email = Auth::sanitize(self::nc($dati, 'Email'));
        $telefono = Auth::sanitize(self::nc($dati, 'Telefono'));
        $indirizzo = Auth::sanitize(self::nc($dati, 'Indirizzo'));
        $password = self::nc($dati, 'Password');

        if (empty($nome)) return ['error' => 'Il nome è obbligatorio.'];
        if (empty($cognome)) return ['error' => 'Il cognome è obbligatorio.'];
        if (empty($email)) return ['error' => "L'email è obbligatoria."];
        if (!Auth::validateEmail($email)) return ['error' => 'Email non valida.'];
        if (empty($password)) return ['error' => 'La password è obbligatoria.'];
        if (strlen($password) < 6) return ['error' => 'La password deve avere almeno 6 caratteri.'];

        $c = new self();
        $c->Nome = $nome;
        $c->Cognome = $cognome;
        $c->Email = $email;
        $c->Telefono = $telefono;
        $c->Indirizzo = $indirizzo;
        $c->Password = password_hash($password, PASSWORD_DEFAULT);
        $c->save();

        return ['success' => 'Cliente creato con successo.', 'id' => $c->id];
    }

    public static function modifica($id, $dati)
    {
        $c = self::find($id);
        if (!$c) return ['error' => 'Cliente non trovato.'];

        $nome = Auth::sanitize(self::nc($dati, 'Nome'));
        $cognome = Auth::sanitize(self::nc($dati, 'Cognome'));
        $email = Auth::sanitize(self::nc($dati, 'Email'));
        $telefono = Auth::sanitize(self::nc($dati, 'Telefono'));
        $indirizzo = Auth::sanitize(self::nc($dati, 'Indirizzo'));
        $password = self::nc($dati, 'Password');

        if (empty($nome)) return ['error' => 'Il nome è obbligatorio.'];
        if (empty($cognome)) return ['error' => 'Il cognome è obbligatorio.'];
        if (empty($email)) return ['error' => "L'email è obbligatoria."];
        if (!Auth::validateEmail($email)) return ['error' => 'Email non valida.'];

        $c->Nome = $nome;
        $c->Cognome = $cognome;
        $c->Email = $email;
        $c->Telefono = $telefono;
        $c->Indirizzo = $indirizzo;
        if (!empty($password)) {
            $c->Password = password_hash($password, PASSWORD_DEFAULT);
        }
        $c->save();

        return ['success' => 'Cliente modificato con successo.', 'id' => $c->id];
    }

    public static function cancella($id)
    {
        $deleted = self::destroy($id);
        if ($deleted === 0) return ['error' => 'Cliente non trovato.'];
        return ['success' => 'Cliente eliminato con successo.', 'id' => $id];
    }

    public static function ottieni($id) { return self::find($id); }

    public static function tutti()
    {
        return self::orderBy('Cognome', 'asc')->orderBy('Nome', 'asc')->get();
    }

    public static function cerca($termine)
    {
        $t = '%' . $termine . '%';
        return self::where('Nome', 'like', $t)
            ->orWhere('Cognome', 'like', $t)
            ->orWhere('Email', 'like', $t)
            ->orWhere('Telefono', 'like', $t)
            ->orderBy('Cognome', 'asc')
            ->orderBy('Nome', 'asc')
            ->get();
    }

    public static function conta() { return self::query()->count(); }

    public static function elencoDispositivi($clienteId)
    {
        return Dispositivo::whereIn('id', function ($q) use ($clienteId) {
            $q->select('dispositivo_id')->from('possiede')->where('cliente_id', $clienteId);
        })->get();
    }
}
