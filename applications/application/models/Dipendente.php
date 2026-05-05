<?php

use Illuminate\Database\Eloquent\Model;

class Dipendente extends Model
{
    protected $table = 'DIPENDENTE';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function crea($dati)
    {
        $nome = Auth::sanitize($dati['nome'] ?? '');
        $email = Auth::sanitize($dati['email'] ?? '');
        $password = $dati['password'] ?? '';
        $salario = (float)($dati['salario_orario'] ?? 0);
        $ruolo = Auth::sanitize($dati['ruolo'] ?? 'dipendente');

        if (empty($nome)) return ['error' => 'Il nome è obbligatorio.'];
        if (empty($email)) return ['error' => "L'email è obbligatoria."];
        if (!Auth::validateEmail($email)) return ['error' => 'Email non valida.'];
        if (empty($password)) return ['error' => 'La password è obbligatoria.'];
        if ($salario <= 0) return ['error' => 'Il salario orario deve essere maggiore di 0.'];

        $d = new self();
        $d->nome = $nome;
        $d->salario_orario = $salario;
        $d->email = $email;
        $d->password = password_hash($password, PASSWORD_DEFAULT);
        $d->ruolo = $ruolo;
        $d->save();

        return ['success' => 'Dipendente creato con successo.', 'id' => $d->id];
    }

    public static function modifica($id, $dati)
    {
        $d = self::find($id);
        if (!$d) return ['error' => 'Dipendente non trovato.'];

        $nome = Auth::sanitize($dati['nome'] ?? '');
        $email = Auth::sanitize($dati['email'] ?? '');
        $password = $dati['password'] ?? '';
        $salario = (float)($dati['salario_orario'] ?? 0);
        $ruolo = Auth::sanitize($dati['ruolo'] ?? 'dipendente');

        if (empty($nome)) return ['error' => 'Il nome è obbligatorio.'];
        if (empty($email)) return ['error' => "L'email è obbligatoria."];
        if (!Auth::validateEmail($email)) return ['error' => 'Email non valida.'];
        if ($salario <= 0) return ['error' => 'Il salario orario deve essere maggiore di 0.'];

        $d->nome = $nome;
        $d->salario_orario = $salario;
        $d->email = $email;
        $d->ruolo = $ruolo;
        if (!empty($password)) {
            $d->password = password_hash($password, PASSWORD_DEFAULT);
        }
        $d->save();

        return ['success' => 'Dipendente modificato con successo.', 'id' => $d->id];
    }

    public static function cancella($id)
    {
        $deleted = self::destroy($id);
        if ($deleted === 0) return ['error' => 'Dipendente non trovato.'];
        return ['success' => 'Dipendente eliminato con successo.', 'id' => $id];
    }

    public static function ottieni($id) { return self::find($id); }
    public static function tutti() { return self::orderBy('nome', 'asc')->get(); }

    public static function cerca($termine)
    {
        $t = '%' . $termine . '%';
        return self::where('nome', 'like', $t)
            ->orWhere('email', 'like', $t)
            ->orderBy('nome', 'asc')
            ->get();
    }

    public static function conta() { return self::query()->count(); }
}
