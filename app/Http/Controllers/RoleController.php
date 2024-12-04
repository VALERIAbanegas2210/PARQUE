<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreroleRequest;
use App\Http\Requests\UpdateroleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\usuario;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all(); // Obtener todos los roles
        return view('administracion.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('administracion.roles.create'); // Retorna la vista para crear un nuevo rol
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|max:255',
        ]);

        Role::create(['name' => $request->name, 'guard_name' => 'usuarios']);
        return redirect()->route('admin.Roles.index')->with('success', 'Rol creado con éxito.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('administracion.roles.edit', compact('role'));
    }

    public function update(UpdateroleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        return redirect()->route('admin.Roles.index')->with('success', 'Rol actualizado con éxito.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.Roles.index')->with('success', 'Rol eliminado con éxito.');
    }

    // Método para asignar un rol a un usuario
    public function assignRole(Request $request, $userId)
    {
        $user = usuario::findOrFail($userId);
        $role = Role::findOrFail($request->role_id);

        $user->assignRole($role); // Asignar rol

        return redirect()->route('admin.Roles.index')->with('success', 'Rol asignado correctamente.');
    }

    // Método para eliminar un rol de un usuario
    public function removeRole($userId, $roleId)
    {
        $user = usuario::findOrFail($userId);
        $role = Role::findOrFail($roleId);

        $user->removeRole($role); // Eliminar rol

        return redirect()->route('admin.Roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}