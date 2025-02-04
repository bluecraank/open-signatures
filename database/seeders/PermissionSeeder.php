<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Signatur vorlagen
        Permission::updateOrCreate(['name' => 'create templates', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'read templates', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'update templates', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'delete templates', 'guard_name' => 'sanctum']);

        // Admin user
        Permission::updateOrCreate(['name' => 'create users', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'read users', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'update users', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'delete users', 'guard_name' => 'sanctum']);

        // groups
        Permission::updateOrCreate(['name' => 'create groups', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'read groups', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'update groups', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'delete groups', 'guard_name' => 'sanctum']);

        // Signatur zeitpläne
        Permission::updateOrCreate(['name' => 'create schedules', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'read schedules', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'update schedules', 'guard_name' => 'sanctum']);
        Permission::updateOrCreate(['name' => 'delete schedules', 'guard_name' => 'sanctum']);

        // Weitere Vorlagen zu User hinzufügen
        Permission::updateOrCreate(['name' => 'assign ldap_users to groups', 'guard_name' => 'sanctum']);
        // Weitere Vorlagen zu UserGruppen hinzufügen
        Permission::updateOrCreate(['name' => 'assign ldap_groups to groups', 'guard_name' => 'sanctum']);

        // Logs
        Permission::updateOrCreate(['name' => 'read logs', 'guard_name' => 'sanctum']);


        Role::updateOrCreate(['name' => 'Super Administrator', 'guard_name' => 'sanctum'])
            ->givePermissionTo(Permission::all());

        Role::updateOrCreate(['name' => 'Manager', 'guard_name' => 'sanctum'])
            ->givePermissionTo([
                'create templates',
                'read templates',
                'update templates',
                'delete templates',
                'create schedules',
                'read schedules',
                'update schedules',
                'delete schedules',
                'create groups',
                'read groups',
                'update groups',
                'delete groups',
                'assign ldap_users to groups',
                'assign ldap_groups to groups',
            ]);

        Role::updateOrCreate(['name' => 'User', 'guard_name' => 'sanctum'])
            ->givePermissionTo([
                'read templates',
            ]);


        // Assign Super Administrator role to user with ID 1
        $user = User::whereId(1)->first();
        if ($user) {
            if (count($user->getRoleNames()) == 0) {
                $user->assignRole('Super Administrator');
            }
        }
    }
}
