<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rotulo extends Model
{
    protected $casts = [
        'posicao' => "array"
    ];

    protected $fillable = [
        'nome', 'imagem', 'posicao', //x e y do item rotulado
        'user_id'
    ];

    public function user(){
        return $this->belongsTo("App\User")->withTrashed();
    }
}
