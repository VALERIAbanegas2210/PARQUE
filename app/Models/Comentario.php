<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'descripcion','puntuacion','comunidad_id','usuario_id'
    ];
    public function usuario(){
        return $this->belongsTo(usuario::class,'usuario_id');
    }
    public function comunidad(){
        return $this->belongsTo(comunidad::class,'comunidad_id');
    }
    public function imagenes(){
        return $this->hasMany(Imagen::class,'comentario_id');
    }
    
}
