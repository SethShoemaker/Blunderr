<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;

class TicketsController extends Controller
{
    /**
     * display tickets. 
     * if user is agent, only show tickets assigned to user.
     * If user is client allow them to submit tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $userRole = Auth::user()->role_id;
        $isClient = $userRole === 1;

        $ticketsQuery = DB::table('tickets')
            ->select(
                'projects.name AS project',
                'tickets.id',
                'tickets.subject',
                'tickets.body',
                'users.name AS client',
                'tickets.created_at',
            )
            ->join('users', 'users.id', '=', 'tickets.client_id')
            ->join('projects', 'projects.id', '=', 'tickets.project_id')
            ->where('tickets.org_id', Auth::user()->org_id);


        // If user is agent
        if ($userRole === 2) {
            $ticketsQuery->where('assigned_agent_id', '=', Auth::id())->get();
        }

        $tickets = $ticketsQuery->paginate(30);

        return view(
            'dashboard.tickets.index',
            [
                'isClient' => $isClient,
                'tickets' => $tickets,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = Project::find(Auth::user()->project_id)->pluck('name')->first();
        return view('dashboard.tickets.create')->with(['project' => $project]);
    }

    /**
     * submit new ticket
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {

        $user = Auth::user();

        $validated = $request->validated();

        $ticket = Ticket::create([
            'org_id' => $user->org_id,
            'project_id' => $user->project_id,
            'client_id' => $user->id,
            'subject' => $validated['subject'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('dashboard.tickets.show', $ticket->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = DB::table('tickets')
            ->select([
                'tickets.*',
                'users.name AS client'
            ])
            ->join('users', 'users.id', '=', 'tickets.client_id')
            ->where('tickets.id', $id)
            ->first();

        return view(
            'dashboard.tickets.show',
            [
                'ticket' => $ticket,
            ]
        );
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
