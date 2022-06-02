<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'name',
        'description',
    ];

    /**
     * find the project that belongs to the client
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetClientProject($query)
    {
        return $query->find(Auth::user()->project_id);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('userOrgProjects', function (Builder $builder) {
            $builder->where('org_id', Auth::user()->org_id);
        });
    }
}
