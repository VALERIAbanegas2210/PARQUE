<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardaparque extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'guardaparques';
    /*     $table->string('CI');
            $table->string('nombre');
            $table->integer('edad')->unsigned();
            $table->string('sexo')->nullable();
            $table->string('correo')->unique();
            $table->string('contraseña'); */
    
    public $incrementing = false;  // Desactivar autoincremento para el ID

    protected $fillable = ['id','CI','nombre', 'edad', 'sexo', 'correo','nroCelular','contraseña'];
    //relacion de 1 a muchos con supervisa
    public function supervisas()
    {
        return $this->hasMany(Supervisa::class, 'guardaparque_id');
    }
    public function formularios(){
        return $this->hasMany(Formulario::class,'guardaparque_id');
    }
    

    //metodo estatico para definir el PA
    // Método reutilizable para obtener las comunidades y horarios asignados
    public static function obtenerComunidadesYHorarios($id)
    {
        $result = DB::table('guardaparques')
            ->join('supervisas', 'guardaparques.id', '=', 'supervisas.guardaparque_id')
            ->join('comunidads', 'supervisas.comunidad_id', '=', 'comunidads.id')
            ->join('horarios', 'supervisas.id', '=', 'horarios.supervisa_id')
            ->join('dias', 'horarios.dia_id', '=', 'dias.id')
            ->select(
                'supervisas.id as supervisa_id',
                'comunidads.nombre as comunidad_nombre',
                'comunidads.zona',
                'horarios.id as horario_id',
                'dias.nombre as dia_nombre',
                'horarios.hora_inicio',
                'horarios.hora_fin'
            )
            ->where('guardaparques.id', $id)
            ->get();

        // Convertir horas de 'H:i:s' a 'H:i'
        foreach ($result as $asignacion) {
            $asignacion->hora_inicio = substr($asignacion->hora_inicio, 0, 5); // Extraer 'H:i'
            $asignacion->hora_fin = substr($asignacion->hora_fin, 0, 5);       // Extraer 'H:i'
        }

        return $result;
    }
}
