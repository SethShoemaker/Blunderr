<div id="screen-overlay">
    <img src="{{ asset('images/icons/close.svg') }}" alt="close menu" id='icon-close'>
</div>
<div id="mobile-menu">
    <img src="{{ asset('images/icons/menu.svg') }}" alt="menu icon" id='mobile-menu-open'>
    <span id="logo">Blunderr</span>
</div>
<nav id="sidebar">
    <div id="sidebar-top">
        <span id="logo">Blunderr</span>
    </div>
    <div id="sidebar-body">
        {{ Auth::user()->name . Auth::user()->role_id }}
        @if( Auth::user()->role_id > 1)
            <a href="{{ route('dashboard.home') }}">Home</a>
            <a href='{{ route('dashboard.tickets.index') }}'>Tickets</a>
            <a href='{{ route('dashboard.projects.index') }}'>Projects</a>
            <a href="{{ route('dashboard.members.index') }}">Members</a>
        @else
            <a href="{{ route('dashboard.home') }}">Home</a>
            <a href='{{ route('dashboard.tickets.index') }}'>Tickets</a>
        @endif
        <a href="{{ route('welcome') }}">Exit Dashboard</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form> 
    </div>
</nav>