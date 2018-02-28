<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gift-Shop') }} - @yield('title', 'Главная')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/vendors.css') }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<div id="app">
    <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-primary" style="box-shadow: #343a40 2px 0 10px;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Gift-Shop') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ Route::currentRouteNamed('home.contacts') ? 'active' : '' }}">
                        <a href="{{ route('home.contacts') }}" class="nav-link">
                            <span class="oi oi-map-marker" title="Контакты" aria-hidden="true"></span>
                            Контакты
                        </a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('home.conditions') ? 'active' : '' }}">
                        <a href="{{ route('home.conditions') }}" class="nav-link">
                            <span class="oi oi-spreadsheet" title="Условия работы" aria-hidden="true"></span>
                            Условия работы
                        </a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">Вход</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">Регистрация</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->isAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <span class="oi oi-cog" title="Управление сайтом" aria-hidden="true"></span>
                                        Управление сайтом
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <span class="oi oi-account-logout" title="icon account-logout" aria-hidden="true"></span>
                                    Выйти
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    @yield('sidebar')
                </div>
                <div class="col-md-9">
                    @if(!Route::currentRouteNamed('home.index'))
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home.index') }}">
                                        Главная
                                    </a>
                                </li>
                                @if(Route::currentRouteNamed('home.contacts'))
                                    <li class="breadcrumb-item">Контакты</li>
                                @endif
                                @if(Route::currentRouteNamed('home.conditions'))
                                    <li class="breadcrumb-item">Условия работы</li>
                                @endif

                                @if(Route::currentRouteNamed('home.categories.*'))
                                    <li class="breadcrumb-item">Каталог</li>
                                @endif
                                @if(Route::currentRouteNamed('home.categories.show'))
                                    <li class="breadcrumb-item {{ Route::currentRouteNamed('home.categories.show') ? 'active' : '' }}"
                                            {{ Route::currentRouteNamed('home.categories.show') ? 'aria-current="page"' : '' }}>{{ $category->name }}</li>
                                @endif

                            </ol>
                        </nav>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
