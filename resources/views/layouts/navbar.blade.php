<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item {{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">Домашняя страница</a>
            </li>
            <li class="nav-item {{ (Request::is('servers') || Request::is('servers/*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('servers') }}">Список серверов</a>
            </li>
        </ul>
    </div>
</nav>