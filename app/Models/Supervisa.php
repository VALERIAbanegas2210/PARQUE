<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisa extends Model
{
    use HasFactory;

    protected $fillable = ['guardaparque_id', 'comunidad_id'];

    //relacion de muchos a 1 con guardaparqueSexo
    public function guardaparque()
    {
        return $this->belongsTo(Guardaparque::class, 'guardaparque_id');
    }
    //relacion de muchos a 1 con comunidadSexo
    public function comunidad()
    {
        return $this->belongsTo(Comunidad::class, 'comunidad_id');
    }
    //relacion de muchos a 1 con horariosSex
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'supervisa_id');
    }
}
