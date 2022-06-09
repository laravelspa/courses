<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = Role::create(["name" => User::R_OWNER]);
        $owner->syncPermissions(User::P_DEFAULT_OWNER);
        $admin = Role::create(["name" => User::R_ADMIN]);
        $admin->syncPermissions(User::P_DEFAULT_ADMIN);
        $teacher = Role::create(["name" => User::R_TEACHER]);
        $teacher->syncPermissions(User::P_DEFAULT_TEACHER);
        Role::create(["name" => User::R_GUEST]);
    }
}
