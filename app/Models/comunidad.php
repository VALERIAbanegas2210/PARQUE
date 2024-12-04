<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comunidad extends Model
{
    use HasFactory;
    protected $table = 'comunidads';
    protected $fillable = [
        'nombre',
        'descripcion',
        'zona',
        'disponibilidad'
    ];
    //relacion de 1 a muchos con supervisa
    public function supervisas()
    {
        return $this->hasMany(Supervisa::class,'comunidad_id');
    }
    //relacion de 1 a muchos con comentarios
    public function comentarios(){
        return $this->hasMany(Comentario::class,'comunidad_id');
    }

    public function rutasTuristicas(){
        return $this->hasMany(RutaTuristica::class,'comunidad_id');
    }

    public function formularios(){
        return $this->hasMany(Formulario::class,'comunidad_id');
    }
}