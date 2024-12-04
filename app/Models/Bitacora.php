<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'ip_address'];

    // Define la relación con el modelo Usuario
    public function user()
    {
        return $this->belongsTo(usuario::class, 'user_id'); // Verifica que Usuario esté importado correctamente
    }
}