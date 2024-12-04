<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tipo_entrada extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'tipo_entradas';
    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
    ];
    public function entradas(){
        return $this->hasMany(Entrada::class,'tipo_entrada_id');
    }
    public function formularios(){
        return $this->hasMany(Formulario::class,'tipo_entrada_id');
    }
    public static function getIdTipoEntrada($cadenaTipoEntrada){
        switch(strtoupper($cadenaTipoEntrada)){
            case "ESTUDIANTE": return 1;
            case "NACIONAL": return 3;
            case "EXTRANJERO":return 2;
            case "EXTRANJERO-MENOR":return 4;
        }
        return null;
    }
}