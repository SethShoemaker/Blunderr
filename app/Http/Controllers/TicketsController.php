<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;
use App\Models\TicketStatus;

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
                'tickets.status_id',
                'ticket_statuses.status',
                'tickets.created_at',
            )
            ->join('ticket_statuses', 'ticket_statuses.id', '=', 'tickets.status_id')
            ->join('projects', 'projects.id', '=', 'tickets.project_id')
            ->where('tickets.org_id', Auth::user()->org_id);


        // If user is agent, only display assigned tickets
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
     * Show the form for creating a new ticket.
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
            'status_id' => 1,
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
        $ticket = Ticket::find($id);

        $project = $ticket::getProject();

        $status = TicketStatus::find($ticket->status_id);

        $client = User::find($ticket->client_id);
        $agent = User::find($ticket->assigned_agent_id);

        $canSubmit = Auth::user()->role_id === 2;

        $canAssign = Auth::user()->role_id > 2;

        if ($canAssign) {
            $agents = User::getAgents()->get();
        }

        return view(
            'dashboard.tickets.show',
            [
                'ticket' => $ticket,
                'ticketStatus' => $status->status,
                'ticketProjectName' => $project->name,
                'ticketClientName' => $client->name,
                'ticketAgentName' => $agent->name ?? 'UNASSIGNED',
                'canSubmit' => $canSubmit,
                'canAssign' => $canAssign,
                'agents' => $agents ?? null,
            ]
        );
    }

    /**
     * Assign or remove agent 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request, $id)
    {

        $ticket = Ticket::find($id);

        if ($request->agent) {
            $ticket->status_id = 2;
            $ticket->assigned_agent_id = $request->agent;
        } else {
            $ticket->status_id = 1;
            $ticket->assigned_agent_id = NULL;
        }

        $ticket->save();

        return redirect()->route('dashboard.tickets.index');
    }

    /**
     * Change status to under review
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        $ticket->status_id = 3;
        $ticket->save();

        return redirect()->route('dashboard.tickets.index');
    }

    /**
     * Approve the ticket
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        $ticket->status_id = 4;
        $ticket->save();

        return redirect()->route('dashboard.tickets.index');
    }
}
