<nav class="navbar page-header">

    <a style="width: auto" class="navbar-brand" href="{{ url('/') }}">
        Sistem Informasi Geografis Minimarket
    </a>

    <ul class="navbar-nav ml-auto">
        @if(Auth::check())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="ml-1">{{ Auth::user()->name }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <i class="icon icon-home"></i> Perusahaan
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="icon icon-settings"></i> Toko
                    </a>
                    <a href="#" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout').submit()">
                        <i class="icon icon-lock"></i> Keluar
                    </a>
                </div>
            </li>
        @else
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('login') }}">Masuk</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}">Daftar</a>
                </li>
            </ul>
        @endif
    </ul>
</nav>

<form action="{{ route('logout') }}" method="post" id="logout">
    @csrf
</form>