<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gift-Shop') }} Управление - @yield('title', 'Главная')</title>

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
    <nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.orders.index') }}">
                {{ config('app.name', 'Gift-Shop') }} Управление
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ Route::currentRouteNamed('admin.orders.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link">
                            <span class="oi oi-document" title="Заказы" aria-hidden="true"></span>
                            Заказы
                        </a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('admin.users.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}" class="nav-link">
                            <span class="oi oi-people" title="Пользователи" aria-hidden="true"></span>
                            Пользователи
                        </a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('admin.categories.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link">
                            <span class="oi oi-list" title="Категории" aria-hidden="true"></span>
                            Категории
                        </a>
                    </li>
                    <li class="nav-item {{ Route::currentRouteNamed('admin.products.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.products.index') }}" class="nav-link">
                            <span class="oi oi-list-rich" title="Товары" aria-hidden="true"></span>
                            Товары
                        </a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('home.index') }}">
                                <span class="oi oi-home" title="Главная страница" aria-hidden="true"></span>
                                Главная страница
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <span class="oi oi-account-logout" title="Выйти" aria-hidden="true"></span>
                                Выйти
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
</div>
</body>
</html>
