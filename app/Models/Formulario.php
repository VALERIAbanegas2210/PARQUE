<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formulario extends Model
{
    use HasFactory;
    protected $fillable = [
        'ci',
        'nombre',
        'edad',
        'pasaporte',
        'tiempoEstadia',
        'fechaIngreso',
        'fechaSalida',
        'fechaReserva',
        'estado',
        'nacionalidad',
        'estadoUsuario',
        'departamento_id',
        'tipo_pago_id',
        'ruta_turistica_id',
        'reserva_id',
        'tipo_entrada_id',
        'comunidad_id',
        'entrada_id',
        'bandera',
        'guardaparque_id'
    ];

    public $timestamps = false; // Desactivar automáticamente created_at y updated_at
    // Relaciones con otras tablas

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class,'formulario_id');
    }

    public function rutaTuristica()
    {
        return $this->belongsTo(RutaTuristica::class, 'ruta_turistica_id');
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    public function guardaparque()
    {
        return $this->belongsTo(Guardaparque::class, 'guardaparque_id');
    }

    public function tipoEntrada()
    {
        return $this->belongsTo(tipo_entrada::class, 'tipo_entrada_id');
    }

    public function comunidad()
    {
        return $this->belongsTo(comunidad::class, 'comunidad_id');
    }

    public function entrada()
    {
        return $this->belongsTo(Entrada::class, 'entrada_id');
    }


    public static function cambioElTipoEntrada($idTipoEntradaAnterior,$idTipoEntradaActual){
        return $idTipoEntradaActual==$idTipoEntradaAnterior;
    }

    public static function yaEstanTodosPagados($idFormulario){
        $formularios= Formulario::findOrFail($idFormulario);
        foreach($formularios as $formulario){
            if($formulario->estado=="PENDIENTE"){
                return false;
            }
        }
        return true;
    }

    public static function obtenerVentasHoy(){

    }
    public static function obtenerVentasEsteMes(){

    }
    public static function obtenerVentasEsteAño(){

    }
    
}
