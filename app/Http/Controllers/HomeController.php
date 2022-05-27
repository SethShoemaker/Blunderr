<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function home()
    {

        $isClient = Auth::user()->role_id === 1;

        if ($isClient) {

            if (Auth::user()->project_id === null) {
                return redirect()->route('organization.await');
            }

            $clientProjectID = Auth::user()->project_id;
            $clientProject = Project::find($clientProjectID);

            $heading = $clientProject->name;
            $body = $clientProject->description;

            // Implements global scope
            $numTickets = Ticket::where('project_id', $clientProjectID)->count();
        } else {

            // Implements global scope
            $organization = Organization::first();

            $heading = $organization->name;
            $body = $organization->description;

            // Implements global scope
            $numTickets = Ticket::count();

            // Implements global scope
            $numProjects = Project::count();

            $numMembers = User::where('org_id', Auth::user()->org_id)->count();

            $user = User::findOrFail(Auth::id());
            $canEdit = $user->role_id >= 3;
        }

        return view(
            'dashboard.home',
            [
                'isClient' => $isClient,
                'heading' => $heading,
                'body' => $body,
                'numTickets' => $numTickets,
                'numProjects' => $numProjects ?? null,
                'numMembers' => $numMembers ?? null,
                'canEdit' => $canEdit ?? null,
            ]
        );
    }
}
