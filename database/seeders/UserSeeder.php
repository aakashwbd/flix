<?php


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                         'name'=> 'Admin',
                         'user_role_id'=> 1,
                         'email'=> 'admin@admin.com',
                         'dob'=>1990,
                         'age'=>32,
                         'image'=>  "https://www.dallalii.com/img/admin/logo.png",
                         'password'=> Hash::make('admin123456')
                     ]);
        User::create([
             'username'=> 'test user 1',
             'user_role_id'=> 3,
             'email'=> 'test1@user.com',
             'dob'=>1980,
             'age'=>27,
             'address'=>'Dhaka, Bangladesh',
             'image'=>  "https://www.dallalii.com/img/admin/logo.png",
             'password'=> Hash::make('123456')
        ]);

        User::create([
             'username'=> 'test user 2',
             'user_role_id'=> 3,
             'email'=> 'test2@user.com',
             'dob'=>1980,
            'address'=>'Dhaka, Bangladesh',
             'image'=>  "https://www.dallalii.com/img/admin/logo.png",
             'password'=> Hash::make('123456')
        ]);

        User::factory()->count(10)->create();
    }
}
