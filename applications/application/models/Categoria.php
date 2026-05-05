<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

class Categoria extends Model
{
    protected $table = 'Categoria';
    protected $primaryKey = 'nome_categoria';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public static function crea($nome)
    {
        $c = new self();
        $c->nome_categoria = Auth::sanitize($nome);
        $c->save();

        return ['success' => 'Categoria creata con successo.', 'id' => $nome];
    }

    public static function ottieni($nome)
    {
        return self::find($nome);
    }

    public static function cancella($nome)
    {
        return self::destroy($nome);
    }

    public static function tutti()
    {
        return self::orderBy('nome_categoria', 'asc')->get();
    }

    public static function dispositivi($categoriaNome)
    {
        return Dispositivo::whereIn('id', function ($q) use ($categoriaNome) {
            $q->select('dispositivo_id')->from('appartiene')->where('nome_categoria', $categoriaNome);
        })->get();
    }

    public static function conta()
    {
        return self::query()->count();
    }
}
