<h2><a href="{{ url('/') }}">SQUAD Stats</a></h2>
<nav>
    <ul>
        <li><a href="{{ route('servers') }}">Servers</a></li>
        <li><a href="{{ route('players') }}">Players</a></li>
        <li><a href="{{ route('matches') }}">Matches</a></li>
    </ul>
</nav>
<nav>
    <form method="POST" action="{{ url('search') }}" name="search">
        @csrf
        <input type="text" name="searchString" autocomplete="off" title="Search Bar" disabled placeholder="WIP" />
        <button type="submit" name="search" title="Search" disabled>Search</button>
    </form>
    @auth
    <a href="{{ route('settings') }}" title="Settings">{{ auth()->user()->name }}</a>
    @endauth

    @guest
    <form method="GET" action="{{ route('login.steam') }}" name="signin">
        <button type="submit" title="Sign In">Sign In</button>
    </form>
    @endguest
</nav>