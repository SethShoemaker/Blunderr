<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    use HasFactory;


    /**
     * This model refers to ticket statuses table.
     *
     * @var string
     */
    protected $table = 'ticket_statuses';

    protected $fillable = [
        'status',
    ];
}
