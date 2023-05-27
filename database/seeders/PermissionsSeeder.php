<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'create_account',
            'get_accounts_info',
            'get_all_accounts',
            'transfer',
            'get_all_transfers',
            'withdrawal',
            'deposit',
            'get_transactions_history'
         ];

        foreach ($permissions as $permission) {
            $is_exist = Permission::where('name',$permission)->first();
            if(!$is_exist){
                Permission::create(['name' => $permission]);
            }
        }
    }
}
