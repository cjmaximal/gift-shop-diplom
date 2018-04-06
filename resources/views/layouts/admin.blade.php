<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gift-Shop') }} Управление - @yield('title', 'Главная')</title>

    @include('components.favicon')
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors.css') }}">
    @yield('style')
    <link rel="stylesheet" href="{{ asset('vendors/select2/css/select2.min.css') }}">
    {!! NoCaptcha::renderJs('ru') !!}
</head>
<body>
@include('components.loader')
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
        <div class="container-fluid">
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
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('script')
{{-- Plugins --}}
<script src="{{ asset('vendors/select2/js/select2.min.js') }}"></script>
</body>
</html>
