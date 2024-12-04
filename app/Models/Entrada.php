<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entrada extends Model
{
    use HasFactory;
    use SoftDeletes;
    /*$table->string('nit');
            $table->string('codigoAutorizacion');
            $table->string('estado');
            $table->unsignedBigInteger('tipo_entrada_id');//llave de referencia para tipo de entrada
            /*$table->unsignedBigInteger('comunidad_id');
            
            $table->foreign('comunidad_id')->references('id')->on('comunidads')->onDelete('cascade')->onUpdate('cascade');*/
            
    protected $fillable=[
        'nit','estado','codigoAutorizacion','tipo_entrada_id','fechaLimiteEmision'
    ];

    public function tipoEntrada(){
        return $this->belongsTo(tipo_entrada::class,'tipo_entrada_id');
    }
    
    public function formulario(){
        return $this->hasOne(Formulario::class,'entrada_id');
    }
    public const NIT="121787023";
}
