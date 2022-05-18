<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::create([
            'name'=> 'Free',
        ]);

        Package::create([
            'name'=> 'Bronze',
        ]);

        Package::create([
            'name'=> 'Silver',
        ]);

        Package::create([
            'name'=> 'Plus',
        ]);

    }
}
