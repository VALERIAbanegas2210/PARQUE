<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';
    protected $fillable = [
        'ruta',
        'comentario_id',
    ];

    // Relación con el modelo Comentario
    public function comentario()
    {
        return $this->belongsTo(Comentario::class,'comentario_id');
    }
}
