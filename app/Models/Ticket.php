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
        'status_id',
        'subject',
        'body',
    ];

    /**
     * find tickets of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfProject($query, $id)
    {
        return $query->where('tickets.project_id', $id);
    }

    /**
     * find tickets that are not completed.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncomplete($query)
    {
        return $query->where('status_id', '!=', 4);
    }

    /**
     * find tickets of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetProject($query)
    {
        return $query->select('projects.name')->join('projects', 'projects.id', '=', 'tickets.project_id')->first();
    }

    /**
     * Only get tickets for user's organization
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function booted()
    {
        static::addGlobalScope('userOrgTickets', function (Builder $builder) {
            $builder->where('tickets.org_id', Auth::user()->org_id);
        });
    }
}
