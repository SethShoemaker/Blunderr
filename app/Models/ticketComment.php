<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;

    protected $table = 'ticket_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_id',
        'poster_id',
        'body',
    ];

    /**
     * find comments of a certain ticket.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfTicket($query, $id)
    {
        return $query->where('ticket_comments.ticket_id', $id);
    }

    /**
     * Add poster name to select query
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPosterName($query)
    {
        return $query
            ->select(
                'ticket_comments.*',
                'users.name'
            )
            ->join('users', 'users.id', '=', 'ticket_comments.poster_id');
    }
}
