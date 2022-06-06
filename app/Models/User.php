<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'org_id',
        'role_id',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scope a query to only include clients of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGrab($query, $id)
    {
        return $query->where('users.id', $id);
    }

    /**
     * Scope a query to only include clients of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfOrg($query)
    {
        return $query->where('users.org_id', Auth::user()->org_id);
    }

    /**
     * Scope a query to only include clients of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRoleAndProject($query)
    {
        return $query->select(
            'users.*',
            'user_roles.title AS role',
            'projects.name AS project'
        )
            ->join('user_roles', 'user_roles.id', '=', 'users.role_id')
            ->leftJoin('projects', 'projects.id', '=', 'users.project_id');
    }

    /**
     * Scope a query to only include clients of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query
            ->where('users.name', 'LIKE', '%' . $search . '%')
            ->orWhere('user_roles.title', 'LIKE', '%' . $search . '%');
    }

    /**
     * Scope a query to only include clients of a certain project.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetAgents($query)
    {
        return $query->where('role_id', 2)->where('org_id', Auth::user()->org_id);
    }
}
