<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userOwner = User::create([
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'name' => 'owner',
            'phone' => '12345678901',
            'active' => 1,
            'password' => Hash::make('owner')
        ]);
        $userTeacher = User::create([
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'name' => 'teacher',
            'phone' => '12345678901',
            'password' => Hash::make('teacher')
        ]);
        $userAdmin = User::create([
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'name' => 'admin',
            'phone' => '12345678901',
            'password' => Hash::make('admin')
        ]);
        $owner = Role::findByName('owner');
        $userOwner->syncRoles($owner);
        
        $admin = Role::findByName('admin');
        $userAdmin->syncRoles($admin);
        
        $teacher = Role::findByName('teacher');
        $userTeacher->syncRoles($teacher);

        \App\Models\User::factory(100)->create();
    }
}
