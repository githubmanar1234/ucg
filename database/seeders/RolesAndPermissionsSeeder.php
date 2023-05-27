<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
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

        //give permissions to roles
        $role_admin = Role::where('name','admin')->first();
        $role_client = Role::where('name','client')->first();

        $role_admin->givePermissionTo(['create_account' ,'get_accounts_info','get_all_accounts','get_all_transfers','deposit']);
        $role_client->givePermissionTo(['get_accounts_info','transfer','withdrawal','get_transactions_history']);

        //create demo users and assign roles
        $user = \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@ai1m.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('admin');


        $user = \App\Models\User::create([
            'name' => 'client1',
            'email' => 'client1@ai1m.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('client');

        $user = \App\Models\User::create([
            'name' => 'client2',
            'email' => 'client2@ai1m.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('client');

        $user = \App\Models\User::create([
            'name' => 'client3',
            'email' => 'client3@ai1m.com',
            'password' => bcrypt('password')
        ]);
        $user->assignRole('client');

    }
}
