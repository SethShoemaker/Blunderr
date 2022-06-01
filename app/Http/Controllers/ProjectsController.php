<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Ticket;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // implements global scope
        $projects = Project::all();

        // implements global scope
        $orgName = Organization::pluck('name')->first();

        // Must be at least manager
        $canCreate = (Auth::user()->role_id >= 3) ? true : false;

        return view(
            'dashboard.projects.index',
            [
                'projects' => $projects,
                'orgName' => $orgName,
                'canCreate' => $canCreate,
            ]
        );
    }

    /**
     * Show the form for registering a new project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.projects.create');
    }

    /**
     * Store a newly created project.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        // implements global scope
        $orgID = Organization::pluck('id')->first();

        $newProject = Project::create([
            'org_id' => $orgID,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('dashboard.projects.show', $newProject->id);
    }

    /**
     * Display the specified project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);

        // Must be at least manager
        $canEdit = Auth::user()->role_id > 2;

        $clients = User::clientOf($project->id)->get();

        return view(
            'dashboard.projects.show',
            [
                'project' => $project,
                'canEdit' => $canEdit,
                'clients' => $clients,
            ]
        );
    }

    /**
     * Show the form for editing the project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        return view('dashboard.projects.edit')->with('project', $project);
    }

    /**
     * Update the project.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $validated = $request->validated();

        $project = Project::find($id);

        $project->name = $validated['name'];
        $project->description = $validated['description'];
        $project->save();

        return redirect()->route('dashboard.projects.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        $numOutstandingTickets = Ticket::ofProject($id)->incomplete()->count();

        if ($numOutstandingTickets > 0) {
            return redirect()->back()->withErrors(['action' => 'Project has ' . $numOutstandingTickets . ' outstanding ticket(s)']);
        }

        $numOutstandingClients = User::clientOf($id)->count();

        if ($numOutstandingClients > 0) {
            return redirect()->back()->withErrors(['action' => 'Project has ' . $numOutstandingClients . ' outstanding client(s)']);
        }

        $project->delete();

        return redirect()->route('dashboard.projects.index');
    }
}
