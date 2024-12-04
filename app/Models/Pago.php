<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable=['nombre','monto','formulario_id'];
    public function formulario(){
        return $this->belongsTo(Formulario::class,'formulario_id');
    }
}
