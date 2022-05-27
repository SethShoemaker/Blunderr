<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            ->paginate(60);

        return view('dashboard.members.index')->with('members', $members);
    }

    /**
     * Display the specified resource.
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
                'roles.title',
            )
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->where('users.org_id', Auth::user()->org_id)
            ->where('users.id', $id)
            ->first();

        // Must be at least co owner
        $canEdit = Auth::user()->role_id >= 4;

        $roles = Role::all();

        return view(
            'dashboard.members.show',
            [
                'member' => $member,
                'canEdit' => $canEdit,
                'roles' => $roles,
            ]
        );
    }

    /**
     * Update the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
