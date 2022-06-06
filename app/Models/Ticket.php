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
     * find tickets of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetStatus($query)
    {
        return $query
            ->select(
                'tickets.*',
                'ticket_statuses.status AS status',
            )
            ->join('ticket_statuses', 'ticket_statuses.id', '=', 'tickets.status_id');
    }

    /**
     * find tickets of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatusAndProject($query)
    {
        return $query
            ->select(
                'projects.name AS project',
                'tickets.*',
                'ticket_statuses.status AS status',
            )
            ->join('ticket_statuses', 'ticket_statuses.id', '=', 'tickets.status_id')
            ->join('projects', 'projects.id', '=', 'tickets.project_id');
    }

    /**
     * find tickets of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetProject($query)
    {
        return $query
            ->select(
                'tickets.*',
                'projects.name AS project'
            )
            ->join('projects', 'projects.id', '=', 'tickets.project_id')
            ->first();
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
     * search query
     * needs previous ticket statuses join
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param string $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query
            ->where('tickets.subject', 'LIKE', '%' . $search . '%')
            ->orWhere('tickets.body', 'LIKE', '%' . $search . '%')
            ->orWhere('projects.name', 'LIKE', '%' . $search . '%')
            ->orWhere('ticket_statuses.status', 'LIKE', '%' . $search . '%');
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
