<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrgRequest;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrganizationsController extends Controller
{

    public function create()
    {
        return view('auth.organization.create');
    }

    public function store(StoreOrgRequest $request)
    {

        $validated = $request->validated();

        $organization = Organization::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'owner_id' => Auth::id(),
            'password' => Hash::make($validated['password']),
        ]);

        $user =  User::findOrFail(Auth::id());

        $user->org_id = $organization->id;
        $user->save();


        return redirect()->route('dashboard.home');
    }


    public function search()
    {
        return view('auth.organization.join');
    }
}
