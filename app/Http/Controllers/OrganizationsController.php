<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\JoinOrgRequest;
use App\Http\Requests\StoreOrgRequest;
use App\Http\Requests\UpdateOrgPassRequest;
use App\Http\Requests\UpdateOrgRequest;

class OrganizationsController extends Controller
{

    /**
     * show organization create form
     *
     * @return view
     */
    public function create()
    {
        return view('auth.organization.create');
    }

    /**
     * store new organization
     *
     * @param  \App\Http\Requests\StoreOrgRequest $request
     * @return void
     */
    public function store(StoreOrgRequest $request)
    {

        $validated = $request->validated();

        $organization = Organization::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'owner_id' => Auth::id(),
            'password' => Hash::make($validated['password']),
        ]);
        $role_id = Role::where('title', 'owner')->pluck('id')->first();

        $user =  User::findOrFail(Auth::id());

        $user->org_id = $organization->id;
        $user->role_id = $role_id;
        $user->save();

        return redirect()->route('dashboard.home');
    }

    /**
     * show organization name and description edit form
     *
     * @return void
     */
    public function edit()
    {
        $user =  User::findOrFail(Auth::id());

        if ($user->role >= 3) {
            abort(403);
        }

        $organization = Organization::first();

        $canResetPass = $user->role_id === 5 ? true : false;

        return view(
            'auth.organization.edit',
            [
                'organization' => $organization,
                'canResetPass' => $canResetPass,
            ]
        );
    }

    /**
     * update organization name and description
     *
     * @param  \App\Http\Requests\UpdateOrgRequest $request
     * @return void
     */
    public function update(UpdateOrgRequest $request)
    {
        $validated = $request->validated();

        $organization = Organization::first();

        $organization->name = $validated['name'];
        $organization->description = $validated['description'];
        $organization->save();

        return redirect()->route('dashboard.home');
    }

    /**
     * show password reset form
     *
     * @return void
     */
    public function password_edit()
    {
        $organization = Organization::first();

        return view(
            'auth.organization.passwords.reset',
            [
                'organization' => $organization,
            ]
        );
    }

    /**
     * update organization password
     *
     * @param  \App\Http\Requests\UpdateOrgPassRequest $request
     * @return void
     */
    public function password_update(UpdateOrgPassRequest $request)
    {
        $validated = $request->validated();

        $organization = Organization::first();
        $organization->password = Hash::make($validated['password']);
        $organization->save();

        return redirect()->route('dashboard.home');
    }


    /**
     * shows form for joining organization
     *
     * @return void
     */
    public function search()
    {
        return view('auth.organization.join');
    }


    /**
     * adds user to organization
     *
     * @param  \App\Http\Requests\JoinOrgRequest $request
     * @return void
     */
    public function join(JoinOrgRequest $request)
    {
        $validated = $request->validated();

        $organization = Organization::withoutGlobalScope('userOrg')->where('name', $validated['name'])->first();

        if (!$organization) {
            return redirect()->back()->withErrors(['name' => 'Organization does not exist']);
        }

        if (!Hash::check($validated['password'], $organization->password)) {
            return redirect()->back()->withInput()->withErrors(['password' => 'Password is incorrect']);
        }

        $user =  User::findOrFail(Auth::id());
        $user->org_id = $organization->id;
        $user->save();

        return redirect()->route('dashboard.home');
    }
}