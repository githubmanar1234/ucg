<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'client',
         ];

        foreach ($roles as $role) {
            $is_exist = Role::where('name',$role)->first();
            if(!$is_exist){
                Role::create(['name' => $role]);
            } 
        }
    }
}
