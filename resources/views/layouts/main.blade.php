@yield('php')
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('head')
</head>

<body id="page-top" class="bg-light d-flex flex-column min-vh-100">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary" id="mainNav">
        <div class="container">
            <a class="navbar-brand me-1" href="@auth{{ route('home') }}@endauth"><span
                    class="text-success">e</span>STACJA</a>
            @auth
                @if (Session::get('notificationsAmount') > 0)
                    <a href="{{ route('notifications') }}" class="text-white ms-5">
                        <i class="far fa-bell fa-2x position-relative">
                            <span
                                class="position-absolute border-1 top-0 start-100 translate-middle badge rounded-pill bg-danger fs-6">
                                {{ Session::get('notificationsAmount') }}
                                <span class="visually-hidden">Masz nowe powiadomienia</span>
                            </span>
                        </i>
                    </a>
                @endif
                @empty(Session::get('notificationsAmount'))
                    <a href="{{ route('notifications') }}" class="text-light"><i
                            class="far fa-bell-slash fa-lg ms-5"></i></a>
                @endempty
            @endauth
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item mx-0 mx-lg-1">
                            <a href="{{ route('login') }}" class="nav-link py-3 px-0 px-lg-3 rounded">Zaloguj</a>
                        </li>
                    @else
                        <li class="nav-item mx-0 mx-lg-1">
                            <a href="{{ route('edsPanel') }}" class="nav-link py-3 px-0 px-lg-3 rounded">Terminy</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a href="{{ route('guideList') }}" class="nav-link py-3 px-0 px-lg-3 rounded">Podręcznik</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a href="{{ route('planograms') }}" class="nav-link py-3 px-0 px-lg-3 rounded">Planogramy</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a href="{{ route('userAd') }}" class="nav-link py-3 px-0 px-lg-3 rounded">Wiadomości</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a href="{{ route('tasksMy') }}" class="nav-link py-3 px-0 px-lg-3 rounded">Zadania</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a href="{{ route('userSchedule') }}" class="nav-link py-3 px-0 px-lg-3 rounded">Grafik
                            </a>
                        </li>
                        @can('isAdmin')
                            <li class="nav-item mx-0 mx-lg-1">
                                <a href="{{ route('adminPanel') }}" class="nav-link py-3 px-0 px-lg-3 rounded">Admin</a>
                            </li>
                        @endcan
                        <li class="nav-item mx-0 mx-lg-1">
                            <a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                {{ __('Wyloguj') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>

            </div>
        </div>
    </nav>
    <main class="mb-5">
        @yield('content')
    </main>
    <footer class="mt-auto">
        <div class="copyright py-4 text-center text-white">
            <div class="container">
                <small>&copy; eStacja version {{ config('app.ver') }} by Damian Zamroczynski - 2022 - kontakt:
                    damian.zamroczynski@gmail.com</small>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/scripts.js') }}"></script>
    @yield('js')
</body>

</html>
