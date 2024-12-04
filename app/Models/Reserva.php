<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    /*$table->float('montoTotal');
            $table->tinyInteger('cantidad');
            $table->string('estado');
            $table->dateTime('fechaReserva');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onUpdate('cascade'); */
    protected $fillable=[
        'montoTotal','cantidad','estado','fechaReserva','usuario_id'
    ];
    public $timestamps = false; // Desactivar automáticamente created_at y updated_at
    public function usuario(){
        return $this->belongsTo(usuario::class,'usuario_id');
    }
    
    public function formularios(){
        return $this->hasMany(Formulario::class,'reserva_id')->with('departamento','rutaTuristica','comunidad','tipoEntrada','reserva');
    }
}
