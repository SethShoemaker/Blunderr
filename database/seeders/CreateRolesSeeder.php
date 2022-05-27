<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'title' => 'client'
        ]);

        Role::create([
            'title' => 'agent'
        ]);

        Role::create([
            'title' => 'manager'
        ]);

        Role::create([
            'title' => 'co-owner'
        ]);

        Role::create([
            'title' => 'owner'
        ]);
    }
}
