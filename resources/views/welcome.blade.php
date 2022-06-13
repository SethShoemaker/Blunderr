
@extends('layouts.app')
@section('title', 'Blunderr')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection
@section('content')
    <nav id="navbar">
        <div id="logo">
            Blunderr
        </div>
        <div id="auth-links">
            @guest
                <a href="{{ url('/login') }}" class='btn btn-secondary'>Login</a>
                <a href="{{ url('/register') }}" class='btn btn-primary'>Register</a>
            @else
                <a href="{{ route('dashboard.home') }}" class='btn btn-primary'>Enter Dashboard</a>
            @endguest
        </div>
    </nav>
    <div class="container">
        <section id="about"> 
            <h1>Welcome to Blunderr</h1>
            <p>
                Blunderr is a web application built to allow organizations to track bugs in their software products.
                Organizations register themselves and the projects they have created, then assign clients to the projects.
                Clients then submit help tickets which will be processed by the development team.
                The development team consists of an organization owner, managers, and agents. 
                The owner and the managers see incoming tickets and assign an agent to solve the problem. 
                The agent sees the ticket, creates a solution, then sends it back to the owner and managers.
                If the owner or manager reviewing the ticket is satisfied with the agent's solution, they can approve the ticket and the status will be marked completed.
            </p>
        </section>
        <section id="account">
            <h2>Registering</h2>
            <p>
                Registering with Blunderr is easy, and free.
            </p>
            <div>
                <h3>Creating account</h3>
                <p>
                    When registering, you will fill out your name and email, as well as a password for accessing your account.
                    Afterwards, you will be sent an email which will verify your account and allow you to continue.
                    When the account is successfully created and verfified, you will need to join or create an organization.
                </p>
            </div>
            <div>
                <h3>Joining existing organization</h3>
                <p>
                    When joining an existing organization, you will need to fill out the existing organization's name, and the password.
                    If you do not know the password, ask the organization owner.
                    If the information you entered is correct, then you will become a member of the organization.
                </p>
            </div>
            <div>
                <h3>Creating new organization</h3>
                <p>                    
                    If you are registering a new organization, you will need to fill in the name, description (optional), and a password.
                    Once the organization is created, you will be assigned the 'owner' role, and will enter your dashboard.
                </p>
            </div>
        </section>
        <section id="roles">
            <h2>Roles</h2>
            <p>
                In order to handle different functions within an organization, each member will have a role. 
                The organization owner will be able to assign people different roles. 
            </p>
            <div>
                <h3>Owner</h3>
                <p>
                    The owner has the highest role within an organization, and they have special abilities no other role has.
                    As mentioned before the owner is able to assign other orgnization members to different roles.
                    They are also able to do everything that the managers are able to do.
                </p>
            </div>
            <div>
                <h3>Managers</h3>
                <p>
                    Managers are the organization members that are responsible for managing the work being done on the tickets.
                    Unlike the agents, they are able to see all of the incoming tickets, and are able to assign the tickets to agents.
                    Once the assigned agent is completed with the work needed for the ticket, they can approve the ticket, dissaprove the ticket, and also change the assigned agent.
                    The managers are directly responsible for ensuring the work being done on a ticket is good enough to satisfy the customer.
                </p>
            </div>
            <div>
                <h3>Agents</h3>
                <p>
                    Agents are responsible for addressing the issues brought up by the clients. 
                    In an agent's dashboard they will see a list of tickets that they are assigned to.
                    Once they solve the issue propsosed in the ticket they will submit it to the managers, where it will either be approved or disapproved.
                </p>
            </div>
            <div>
                <h3>Agents</h3>
                <p>
                    The clients for the projects will have a means to submit help tickets for issues with their project. 
                    In their dashboard, they will have their own list of tickets submitted for their project, 
                    whether it be their own or another clients'. The list will list the tickets' statuses so that they can see progress being made on their ticket.
                </p>
            </div>
        </section>
    </div>
@endsection