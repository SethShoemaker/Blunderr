<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            )
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
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

        return view('dashboard.members.show')->with('member', $member);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
