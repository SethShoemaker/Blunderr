<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\User;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $members = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'roles.title',
                'projects.name AS project'
            )
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->leftJoin('projects', 'projects.id', '=', 'users.project_id')
            ->where('users.org_id', Auth::user()->org_id)
            ->paginate(30);

        return view('dashboard.members.index')->with('members', $members);
    }

    /**
     * Show individual user.
     * owner may edit user role
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.created_at',
                'roles.title AS role',
                'projects.name AS project'
            )
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->leftJoin('projects', 'projects.id', '=', 'users.project_id')
            ->where('users.org_id', Auth::user()->org_id)
            ->where('users.id', $id)
            ->first();

        // Must be owner
        $canEdit = Auth::user()->role_id === 4;

        if ($canEdit) {
            $roles = Role::all();
            $projects = Project::all();
        }

        return view(
            'dashboard.members.show',
            [
                'member' => $member,
                'canEdit' => $canEdit,
                'roles' => $roles ?? null,
                'projects' => $projects ?? null,
            ]
        );
    }

    /**
     * Update the user.
     *
     * @param  \App\Http\Requests\UpdateMemberRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::find($id);

        $user->role_id = $validated['role'];
        $user->project_id = $validated['project'] ?? NULL;
        $user->save();

        return redirect()->route('dashboard.members.index');
    }
}
