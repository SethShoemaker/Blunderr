<?php

namespace Database\Seeders;

use App\Models\userRole;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        userRole::create([
            'title' => 'client'
        ]);

        userRole::create([
            'title' => 'agent'
        ]);

        userRole::create([
            'title' => 'manager'
        ]);

        userRole::create([
            'title' => 'owner'
        ]);
    }
}
