<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\User;
use App\Models\UserRole;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = $_GET['search'] ?? null;

        $members = User::ofOrg()->withRoleAndProject()->search($search)->paginate(30);

        return view(
            'dashboard.members.index',
            [
                'search' => $search,
                'members' => $members
            ]
        );
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

        $member = User::grab($id)->ofOrg()->withRoleAndProject()->first();

        // Must be owner
        $canEdit = Auth::user()->role_id === 4;

        if ($canEdit) {
            $roles = UserRole::all();
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

        // Make current user an agent
        if ($validated['role'] == 4) {
            $self = User::find(Auth::id());
            $self->role_id = 2;
            $self->save();
        }

        $user->role_id = $validated['role'];
        $user->project_id = $validated['project'] ?? NULL;
        $user->save();

        return redirect()->route('dashboard.members.index');
    }
}
