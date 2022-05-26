<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function home()
    {
        $organization = Organization::where('id', Auth::user()->org_id)->first();

        return view('dashboard.home')->with('organization', $organization);
    }
}
