<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RutaTuristica extends Model
{
    use HasFactory;
    use SoftDeletes;
    
        // Permitir asignación masiva en los campos nombre y comunidad_id
        protected $fillable = ['nombre', 'comunidad_id','disponibilidad'];

        // Definir la relación con el modelo Comunidad
        public function comunidad() {
            return $this->belongsTo(comunidad::class,'comunidad_id'); // Comunidad debe comenzar con mayúscula
        }
        public function formularios(){
            return $this->hasMany(Formulario::class,'ruta_turistica_id');
        }

}
