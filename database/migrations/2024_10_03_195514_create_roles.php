<?php

use App\Models\Usuario;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create roles with the 'usuarios' guard
        //$role1 = Role::create(['name' => 'admin']);
        //$role2 = Role::create(['name' => 'guardaparque']);

        //$user = usuario::find(1);
        //$user->assignRole($role1);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};