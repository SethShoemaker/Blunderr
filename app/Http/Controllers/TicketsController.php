<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ticketComment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;
use App\Models\TicketType;

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

        $search = $_GET['search'] ?? null;

        $ticketsQuery = Ticket::withStatusAndProjectAndType()->search($search);

        $userRole = Auth::user()->role_id;

        // If user is agent, only display assigned tickets
        if ($userRole === 2) {
            $ticketsQuery->where('assigned_agent_id', '=', Auth::id());
        }

        $isClient = $userRole === 1;

        $tickets = $ticketsQuery->simplePaginate(30);

        return view(
            'dashboard.tickets.index',
            [
                'isClient' => $isClient,
                'tickets' => $tickets,
                'search' => $search,
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
        $project = Project::GetClientProject()->pluck('name')->first();

        $ticketTypes = TicketType::all();

        return view(
            'dashboard.tickets.create',
            [
                'project' => $project,
                'ticketTypes' => $ticketTypes,
            ]
        );
    }

    /**
     * store new ticket
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
            'type_id' => $validated['type'],
        ]);

        return redirect()->route('dashboard.tickets.show', $ticket->id);
    }

    /**
     * Display the specified ticket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::withStatusAndProjectAndType()->where('tickets.id', $id)->first();

        $client = User::find($ticket->client_id);
        $agent = User::find($ticket->assigned_agent_id);

        $comments = ticketComment::ofTicket($ticket->id)->withPosterName()->simplePaginate(5);
        $hasComments = $comments->count() > 0;

        $canSubmit = Auth::user()->role_id === 2;
        $canAssign = Auth::user()->role_id > 2;

        if ($canAssign) {
            $agents = User::getAgents()->get();
        }

        $isComplete = $ticket->status_id === 4;

        return view(
            'dashboard.tickets.show',
            [
                'ticket' => $ticket,
                'ticketClientName' => $client->name,
                'ticketAgentName' => $agent->name ?? 'UNASSIGNED',
                'comments' => $comments,
                'hasComments' => $hasComments,
                'canSubmit' => $canSubmit,
                'canAssign' => $canAssign,
                'agents' => $agents ?? null,
                'isComplete' => $isComplete,
            ]
        );
    }

    /**
     * Comment on a ticket
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comment(Request $request, $id)
    {

        ticketComment::create([
            'ticket_id' => $id,
            'poster_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('dashboard.tickets.show', $id);
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
