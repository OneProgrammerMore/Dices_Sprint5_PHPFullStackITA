<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegristrar;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        $playerRole = Role::create(['guard_name' => 'api' ,'name' => 'player']);
        //$playerRole->givePermissionTo('play');
        
        $adminRole = Role::create(['guard_name' => 'api' , 'name' => 'admin']);
        //$adminRole->givePermissionTo('watch');
        
    }
}
