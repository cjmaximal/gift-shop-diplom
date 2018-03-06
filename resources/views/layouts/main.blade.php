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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    @yield('style')
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
                    <!-- Shopping Cart -->
                    <li>
                        <a class="nav-link shoppingCart" href="javascript:void(0);">
                            <span class="oi oi-cart"></span>
                            Корзина
                        </a>
                    </li>
                    <!-- Shopping Cart End -->
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
                                    <a class="custom-link" href="{{ route('home.index') }}">
                                        Главная
                                    </a>
                                </li>
                                @if(Route::currentRouteNamed('home.contacts'))
                                    <li class="breadcrumb-item">Контакты</li>
                                @endif
                                @if(Route::currentRouteNamed('home.conditions'))
                                    <li class="breadcrumb-item">Условия работы</li>
                                @endif

                                @if(Route::currentRouteNamed('home.categories.*') || Route::currentRouteNamed('home.product.show'))
                                    <li class="breadcrumb-item">Каталог</li>
                                @endif
                                @if(Route::currentRouteNamed('home.categories.show') || Route::currentRouteNamed('home.product.show'))
                                    <li class="breadcrumb-item {{ Route::currentRouteNamed('home.categories.show') ? 'active' : '' }}"
                                            {{ Route::currentRouteNamed('home.categories.show') ? 'aria-current="page"' : '' }}>
                                        <a class="custom-link" href="{{ route('home.categories.show', ['category' => $category->slug]) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endif
                                @if(Route::currentRouteNamed('home.product.show'))
                                    <li class="breadcrumb-item {{ Route::currentRouteNamed('home.product.show') ? 'active' : '' }}"
                                            {{ Route::currentRouteNamed('home.product.show') ? 'aria-current="page"' : '' }}>
                                        <a class="custom-link" href="{{ route('home.product.show', [
                                                'category' => Route::current()->parameter('category')->slug,
                                                'product' => Route::current()->parameter('product')->slug,
                                            ]) }}">
                                            {{ Route::current()->parameter('product')->name }}
                                        </a>
                                    </li>
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
<div class="fixed-bottom scrollup m-4" style="display: none;">
    <button class="btn btn-outline-secondary">
        <span class="oi oi-arrow-circle-top" title="Наверх" aria-hidden="true"></span>
    </button>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendors/jquery.number.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
    $(function () {

        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn('slow');
            } else {
                $('.scrollup').fadeOut('slow');
            }
        });

        $('.scrollup').on('click', 'button', function () {
            $('html, body').animate({
                scrollTop: 0
            }, 800, function () {
                $('.scrollup button').blur();
            });
            return false;
        });

    });
</script>
@yield('script')
</body>
</html>
