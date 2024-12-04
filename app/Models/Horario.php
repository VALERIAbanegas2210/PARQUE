<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $fillable = ['dia_id', 'supervisa_id'];
    
    public function dia(){
        return $this->belongsTo(Dia::class,'dia_id');
    }    
    public function supervisa()
    {
        return $this->belongsTo(Supervisa::class, 'supervisa_id');
    }
}
