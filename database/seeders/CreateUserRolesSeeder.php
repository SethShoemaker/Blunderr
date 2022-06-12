<?php

namespace Database\Seeders;

use App\Models\UserRole;
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
        UserRole::create([
            'title' => 'client'
        ]);

        UserRole::create([
            'title' => 'agent'
        ]);

        UserRole::create([
            'title' => 'manager'
        ]);

        UserRole::create([
            'title' => 'owner'
        ]);
    }
}
