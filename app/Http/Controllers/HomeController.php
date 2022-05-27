<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function home()
    {
        // Implements global scope
        $organization = Organization::first();

        // Implements global scope
        $numProjects = Project::count();

        // Implements global scope
        $numTickets = Ticket::count();

        $numMembers = User::where('org_id', Auth::user()->org_id)->count();

        $user = User::findOrFail(Auth::id());
        $canEdit = $user->role_id >= 3 ? true : false;

        return view(
            'dashboard.home',
            [
                'organization' => $organization,
                'numProjects' => $numProjects,
                'numTickets' => $numTickets,
                'numMembers' => $numMembers,
                'canEdit' => $canEdit,
            ]
        );
    }
}
