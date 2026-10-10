<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * Seed for creating user
 *
 * Class CreateUsersSeeder
 * @package Database\Seeders
 */
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'super_admin')->first();
        $user = User::create([
            'name'     => 'demy2',
            'email'    => 'demy2@ukr.net',
            'password' => Hash::make('super_admin1234'),
        ]);
        $user->assignRole($role);

        $role = Role::where('name', 'admin')->first();
        $user = User::create([
            'name'     => 'admin',
            'email'    => 'admin@ukr.net',
            'password' => Hash::make('admin1234'),
        ]);
        $user->assignRole($role);

        $role = Role::where('name', 'storekeeper')->first();
        $user = User::create([
            'name'     => 'storekeeper',
            'email'    => 'storekeeper@ukr.net',
            'password' => Hash::make('storekeeper1234'),
        ]);
        $user->assignRole($role);

        $role = Role::where('name', 'manager')->first();
        $user = User::create([
            'name'     => 'manager',
            'email'    => 'manager@ukr.net',
            'password' => Hash::make('manager1234'),
        ]);
        $user->assignRole($role);
    }
}

