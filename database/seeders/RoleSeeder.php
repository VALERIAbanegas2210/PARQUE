<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $usuario = Role::create(['name' => 'usuario', 'guard_name' => 'usuarios']);
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'usuarios']);
        $guardaparque = Role::create(['name' => 'guardaparque', 'guard_name' => 'usuarios']);

        Permission::create(['name' => 'layouts.template', 'guard_name' => 'usuarios'])->syncRoles([$usuario, $admin, $guardaparque]);
        Permission::create(['name' => 'usuarios.update', 'guard_name' => 'usuarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'login.submit', 'guard_name' => 'usuarios'])->syncRoles([$usuario, $admin, $guardaparque]);
        Permission::create(['name' => 'usuarios.perfil', 'guard_name' => 'usuarios'])->syncRoles([$usuario, $admin, $guardaparque]);
        Permission::create(['name' => 'updateProfile', 'guard_name' => 'usuarios'])->syncRoles([$usuario, $admin]);
        Permission::create(['name' => 'admin.Roles.index', 'guard_name' => 'usuarios'])->syncRoles([$admin]);
    }
}