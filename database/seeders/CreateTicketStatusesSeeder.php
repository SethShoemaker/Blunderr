<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateTicketStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketStatus::create([
            'status' => 'unassigned',
        ]);

        TicketStatus::create([
            'status' => 'assigned',
        ]);

        TicketStatus::create([
            'status' => 'under review',
        ]);

        TicketStatus::create([
            'status' => 'completed',
        ]);
    }
}
