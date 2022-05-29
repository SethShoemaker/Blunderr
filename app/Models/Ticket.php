<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'project_id',
        'client_id',
        'assigned_agent_id',
        'subject',
        'body',
    ];

    /**
     * Scope a query to include client name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getClientName($query)
    {
        return $query->select('users.name')
            ->join('users', 'users.id', '=', 'tickets.client_id');
    }

    /**
     * Only get tickets for user's organization
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function booted()
    {
        static::addGlobalScope('userOrgTickets', function (Builder $builder) {
            $builder->where('org_id', Auth::user()->org_id);
        });
    }
}
