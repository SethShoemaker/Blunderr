<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    use HasFactory;

    /**
     * This model refers to ticket types table.
     *
     * @var string
     */
    protected $table = 'ticket_types';

    protected $fillable = [
        'type',
    ];
}
