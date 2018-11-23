<nav class="navbar page-header">

    <a style="width: auto" class="navbar-brand" href="{{ url('/') }}">
        <img style="display: block;margin: 0 30px" width="30" src="" alt="logo">
    </a>

    @if($sidebar)
    <a href="#" class="btn btn-link sidebar-mobile-toggle d-lg-none mr-auto">
        <i class="fa fa-bars"></i>
    </a>
    <a href="#" class="btn btn-link sidebar-toggle d-md-down-none">
        <i class="fa fa-bars"></i>
    </a>
    @endif

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="small ml-1">Tes</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <i class="icon icon-home"></i> Dasbor Saya
                </a>
                <a href="#" class="dropdown-item">
                    <i class="icon icon-settings"></i> Pengaturan Akun
                </a>
                <a href="#" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout').submit()">
                    <i class="fa fa-lock"></i> Keluar
                </a>
            </div>
        </li>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('login') }}">Masuk</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('register') }}">Daftar</a>
            </li>
        </ul>
    </ul>
</nav>

<form action="{{ route('logout') }}" method="post" id="logout">
    @csrf
</form>