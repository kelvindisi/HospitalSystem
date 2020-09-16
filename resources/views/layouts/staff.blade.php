<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}" defer></script>
    <script src="{{ asset('js/dataTable.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
</head>
<body>
<div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}"><strong>Mount Kenya</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @guest()
                    <!-- Admin List -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('create_staff') }}" class="nav-link">Add Staff</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('staff_list') }}" class="nav-link">Manage Staff</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Payment Options
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('payment_modes') }}" class="dropdown-item">List</a>
                                <a href="{{ route('add_payment_mode') }}" class="dropdown-item">Add</a>
                            </div>
                        </li>
                    </ul>
                    @endguest
                    <!-- End of Admin List -->

                    @guest() <!-- Finance -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Drugs Inventory
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('drugs.index') }}" class="dropdown-item">List</a>
                                <a href="{{ route('drugs.create') }}" class="dropdown-item">Add</a>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Lab Tests
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('tests.index') }}" class="dropdown-item">List</a>
                                <a href="{{ route('tests.create') }}" class="dropdown-item">Add</a>
                            </div>
                        </li>
                    </ul>
                    <!-- End of Finance List -->
                    @endguest


                    <!-- Receptionist -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('register_patient') }}" class="nav-link">Add Patients</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('patients') }}" class="nav-link">Patient List</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pending_consultations') }}" class="nav-link">Pending Consultations</a>
                        </li>
                    </ul>
                    <!-- End of Receptionist -->
                    
                    <!-- Doctor -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('doctor.index') }}" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">Consultations</a>
                            <div class="dropdown-menu">
                                <a href="{{ route('doctor.pending') }}" class="dropdown-item">Pending</a>
                                <a href="{{ route('doctor.pending_results') }}" class="dropdown-item">With Lab Test(s)</a>
                            </div>
                        </li>
                    </ul>
                    <!-- End Doctor -->
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="admin-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
</body>
</html>
