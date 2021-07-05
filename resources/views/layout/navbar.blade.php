<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{ request()->routeIs('ranking') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ranking') }}">Ranking</a>
            </li>
            <li class="nav-item {{ request()->routeIs('graphs') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('graphs') }}">@lang('Graphs')</a>
            </li>
            @auth()
                <li class="nav-item {{ request()->routeIs('images') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('images') }}">Images</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
            @endauth
        </ul>
    </div>
    @auth()
        Hello, {{ auth()->user()->name }}
    @else
        <a href="{{ route('login') }}">Login</a>
    @endauth
</nav>
