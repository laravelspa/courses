<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission1 = Permission::create(['name' => User::P_VIEW_COURSE]);
        $permission2 = Permission::create(['name' => User::P_ADD_COURSE]);
        $permission3 = Permission::create(['name' => User::P_EDIT_COURSE]);
        $permission4 = Permission::create(['name' => User::P_DELETE_COURSE]);

        $permission1 = Permission::create(['name' => User::P_VIEW_PROGRAM]);
        $permission2 = Permission::create(['name' => User::P_ADD_PROGRAM]);
        $permission3 = Permission::create(['name' => User::P_EDIT_PROGRAM]);
        $permission4 = Permission::create(['name' => User::P_DELETE_PROGRAM]);

        $permission5 = Permission::create(['name' => User::P_VIEW_TABLE]);
        $permission6 = Permission::create(['name' => User::P_ADD_TABLE]);
        $permission7 = Permission::create(['name' => User::P_EDIT_TABLE]);
        $permission8 = Permission::create(['name' => User::P_DELETE_TABLE]);

        $permission9 = Permission::create(['name' =>  User::P_VIEW_USER]);
        $permission10 = Permission::create(['name' => User::P_ADD_USER]);
        $permission11 = Permission::create(['name' => User::P_EDIT_USER]);
        $permission12 = Permission::create(['name' => User::P_DELETE_USER]);

        $permission13 = Permission::create(['name' => User::P_VIEW_SETTING]);
        $permission14 = Permission::create(['name' => User::P_ADD_SETTING]);
        $permission15 = Permission::create(['name' => User::P_EDIT_SETTING]);
        $permission16 = Permission::create(['name' => User::P_DELETE_SETTING]);

        $permission17 = Permission::create(['name' => User::P_VIEW_EVENT]);
        $permission18 = Permission::create(['name' => User::P_ADD_EVENT]);
        $permission19 = Permission::create(['name' => User::P_EDIT_EVENT]);
        $permission20 = Permission::create(['name' => User::P_DELETE_EVENT]);

        $permission17 = Permission::create(['name' => User::P_VIEW_STUDENT]);
        $permission18 = Permission::create(['name' => User::P_ADD_STUDENT]);
        $permission19 = Permission::create(['name' => User::P_EDIT_STUDENT]);
        $permission20 = Permission::create(['name' => User::P_DELETE_STUDENT]);
    }
}
