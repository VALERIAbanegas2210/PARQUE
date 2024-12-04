<?php

namespace App\Models;


use App\Models\role as ModelsRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Attributes\Log;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail; // Importa esta interfaz
use Illuminate\Foundation\Auth\User as Authenticatable; // Cambiar Model a Authenticatable

class usuario extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, HasFactory;
    // Si tu tabla de usuarios no sigue el nombre predeterminado (usuarios), defínelo aquí
    protected $table = 'usuarios';
    protected $guard_name = 'usuarios'; // Asegúrate de que esto esté configurado
    // Si tu campo de clave primaria tiene un nombre distinto de 'id', especifica aquí
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'usuario',
        'correo',
        'contraseña',
        'ci',
        'edad',
        'sexo',
        'pasaporte',
        'nacionalidad',
        'profile_image',
        'nroCelular'
    ];
    public function comentarios(){
        return $this->hasMany(Comentario::class,'usuario_id');
    }
    public function reservas(){
        return $this->hasMany(Reserva::class,'usuario_id');
    }

    // Definir una relación que asocia usuarios con roles
    /*public function roles()
    {
        return $this->belongsToMany(role::class);
    }

    // Método para verificar si un usuario tiene un rol específico
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }*/
    public const LAYOUT_ADMIN="layouts.admin_template";
    public const LAYOUT_USUARIO="layouts.template";
    
    public static function getLayout($id){
        $usuario = usuario::findOrFail($id);
        return $usuario->getRoleNames()->first()=="guardaparque"?usuario::LAYOUT_USUARIO:usuario::LAYOUT_ADMIN;
    }

}