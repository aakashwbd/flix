<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create([
            'name'=> 'superadmin',
                             ]);
        UserRole::create([
                             'name'=> 'admin',
                         ]);
        UserRole::create([
                             'name'=> 'user',
                         ]);
    }
}
