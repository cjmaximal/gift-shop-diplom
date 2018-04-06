<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gift-Shop') }} - @yield('title', 'Главная')</title>

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
    @php
        $shoppingCartItems = \App\Services\ShoppingCartService::getItems();
        $shoppingCart = [
            'count' => count($shoppingCartItems),
            'items' => $shoppingCartItems,
        ];

        $menuItems = \App\Services\MenuService::get();
    @endphp
    <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-primary" style="box-shadow: #343a40 2px 0 10px;">
        <div class="container-fluid">
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
                    @if(!Route::currentRouteNamed('home.shopping_cart') && !Route::currentRouteNamed('order.confirm'))
                        <li>
                            <a class="nav-link shoppingCart {{ $shoppingCart['count'] ? 'active' : ''}}" href="javascript:void(0);" data-toggle="modal" data-target="#shoppingCartModal">
                                <span class="oi oi-cart"></span>
                                Корзина
                                <span class="badge badge-warning" style="display: {{ $shoppingCart['count'] ? 'inline-block' : 'none' }};">{{ $shoppingCart['count'] }}</span>
                            </a>
                        </li>
                    @endif
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
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->isAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.orders.index') }}">
                                        <span class="oi oi-cog"></span>
                                        Управление сайтом
                                    </a>
                                @endif
                                @if(Auth::check())
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                                        <span class="oi oi-person"></span>
                                        Профиль
                                    </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <span class="oi oi-account-logout"></span>
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
                    {{-- Catalog --}}
                    <div class="card border-primary">
                        <div class="card-header font-weight-bold text-white bg-primary">
                            <span class="oi oi-menu" title="Каталог товаров" aria-hidden="true"></span>
                            КАТАЛОГ ТОВАРОВ
                        </div>

                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach($menuItems as $categoryItem)
                                    <li class="list-group-item font-weight-bold {{ Route::currentRouteNamed('home.categories') && Route::current()->parameter('category')->id == $categoryItem['id'] ? 'active' : ''}}">
                                        <a href="{{ route('home.categories.show', ['category' => $categoryItem['slug']]) }}"
                                           class="{{ Route::currentRouteNamed('home.categories') && Route::current()->parameter('category')->id == $categoryItem['id'] ? 'text-white' : ''}}">{{ $categoryItem['name'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    {{-- Catalog End --}}
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
                                    <li class="breadcrumb-item active" aria-current="page">Контакты</li>
                                @endif
                                @if(Route::currentRouteNamed('home.conditions'))
                                    <li class="breadcrumb-item active" aria-current="page">Условия работы</li>
                                @endif
                                @if(Route::currentRouteNamed('home.shopping_cart'))
                                    <li class="breadcrumb-item active" aria-current="page">Корзина</li>
                                @endif
                                @if(Route::currentRouteNamed('home.categories.show'))
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ Route::current()->parameter('category')->name }}
                                    </li>
                                @endif
                                @if(Route::currentRouteNamed('home.product.show'))
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ Route::current()->parameter('product')->name }}
                                    </li>
                                @endif
                                @if(Route::currentRouteNamed('order.confirm'))
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Подтверждение заказа
                                    </li>
                                @endif
                                @if(Route::currentRouteNamed('order.address'))
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Адрес получателя
                                    </li>
                                @endif
                                @if(Route::currentRouteNamed('profile.index'))
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Профиль
                                    </li>
                                @endif
                                @if(Route::currentRouteNamed('profile.address.edit'))
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('profile.index') }}" class="custom-link">Профиль</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Адрес доставки
                                    </li>
                                @endif
                                @if(Route::currentRouteNamed('profile.personal.edit'))
                                    <li class="breadcrumb-item" aria-current="page">
                                        <a href="{{ route('profile.index') }}" class="custom-link">Профиль</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Персональные данные
                                    </li>
                                @endif
                                @if(Route::currentRouteNamed('order.show'))
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Просмотр заказа
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
<!-- ScrollUp -->
<div class="fixed-bottom scrollup m-4" style="display: none;">
    <button class="btn btn-outline-secondary">
        <span class="oi oi-arrow-circle-top" title="Наверх" aria-hidden="true"></span>
    </button>
</div>
<!-- ScrollUp End -->
<!-- Shopping Cart Modal -->
<div class="modal fade" id="shoppingCartModal" tabindex="-1" role="dialog" aria-labelledby="shoppingCartModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shoppingCartModalTitle">Корзина</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($shoppingCart['count'] > 0)
                    @foreach($shoppingCart['items'] as $item)
                        <div class="row mb-2" data-id="{{ $item['id'] }}">
                            <div class="col-2">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-thumbnail">
                            </div>
                            <div class="col-5"><span class="text-dark">{{ $item['name'] }}</span></div>
                            <div class="col-2">
                            <span class="{{ $item['available'] ? 'text-success' : 'text-danger' }}">
                                {{ $item['available'] ? 'В наличии' : 'Отсутствует' }}
                            </span>
                            </div>
                            <div class="col-2">
                                Кол-во: <span class="text-dark font-weight-bold">{{ $item['count'] }}</span>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-danger removeFromCart">
                                    <span class="oi oi-trash" title="Убрать из корзины" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-muted">В корзине нет ни одного товара...</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btnCartContinue" data-dismiss="modal">
                    <span class="oi oi-plus"></span>&nbsp;
                    Продолжить покупки
                </button>
                <a href="{{ route('home.shopping_cart') }}" class="btn btn-success">
                    <span class="oi oi-cart"></span>&nbsp;
                    Перейти в корзину
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Shopping Cart Modal End -->

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('script')
{{-- Plugins --}}
<script src="{{ asset('vendors/jquery.number.min.js') }}"></script>
<script src="{{ asset('vendors/jquery.preloader.js') }}"></script>
<script src="{{ asset('vendors/select2/js/select2.min.js') }}"></script>
</body>
</html>
