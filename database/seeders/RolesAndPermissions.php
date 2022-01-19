<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'editar bitacora']);
        Permission::create(['name' => 'borrar bitacora']);
        Permission::create(['name' => 'publicar bitacora']);
        Permission::create(['name' => 'anular publicacion bitacora']);
        Permission::create(['name' => 'ver bitacora']);
        Permission::create(['name' => 'revisar bitacora']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'revisior']);
        $role->givePermissionTo(['editar bitacora', 'revisar bitacora', 'anular publicacion bitacora', 'borrar bitacora', 'publicar bitacora', 'revisar bitacora', 'ver bitacora']);

        $role = Role::create(['name' => 'capturista'])
        ->givePermissionTo(['editar bitacora', 'publicar bitacora', 'ver bitacora', 'borrar bitacora']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // obtener el usuario
        $usuario = User::where('id', 2)->first();
        // asignamos rol
        $usuario->assignRole('capturista');

        // obtener el usuario
        $usuario_revisor = User::where('id', 1)->first();
        // asignamos rol
        $usuario_revisor->assignRole('revisior');
    }
}
