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
        'subject',
        'body',
    ];

    /**
     * Only get tickets that are assigned to agent
     *
     * @param  mixed $query
     * @return void
     */
    public function agentAssigned($query)
    {
        return $query->where('assigned_user_id', Auth::id());
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
