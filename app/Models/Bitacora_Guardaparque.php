<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora_Guardaparque extends Model
{
    use HasFactory;
    protected $table = 'bitacora__guardaparques';

    
    protected $fillable = [
        'id_comunidad',
        'id_guardaparque',
        'nombreComunidad',
        'nombreGuardaparque',
        'fecha',
        'tipo',
    ];
    public $timestamps = false;
}
