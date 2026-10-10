<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * Seed for creating roles
 *
 * Class CreateRoleSeeder
 * @package Database\Seeders
 */
class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'name'       => 'super_admin',
                'guard_name' => 'web',
            ],
            [
                'name'       => 'admin',
                'guard_name' => 'web',
            ],
            [
                'name'       => 'storekeeper',
                'guard_name' => 'web',
            ],
            [
                'name'       => 'manager',
                'guard_name' => 'web',
            ],
        ]);
    }
}
