<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbar">
    <!-- Container wrapper -->
    <div class="container">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Mamateam') }}</a>
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left links -->
            <ul class="navbar-nav ms-auto align-items-right">
                <li class="nav-item">
                    <a class="nav-link active mx-2" aria-current="page" href="#home"><span>Home</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2" aria-current="page" href="#next-event"><span>Eventi</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2" aria-current="page" href="#about"><span>Chi siamo</span></a>
                </li>
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item ms-1">
                            <a class="btn btn-primary btn-rounded" role="button"
                               href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                           href="#"
                           id="navbarDropdownMenuLink"
                           role="button"
                           data-mdb-toggle="dropdown"
                           aria-expanded="false"
                        >
                            <img
                                src="{{asset('assets/img/avatar').'/'.\Illuminate\Support\Facades\Auth::user()->avatar}}"
                                class="rounded-circle"
                                height="30"
                                alt=""
                                loading="lazy"
                            />
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    {{ __('Dashboard') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @endguest
            </ul>
            <!-- Left links -->
        </div>
        <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->
