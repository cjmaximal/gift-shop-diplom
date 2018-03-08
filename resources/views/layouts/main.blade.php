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
    @php
        $shoppingCartItems = \App\Services\ShoppingCartService::getItems();
        $shoppingCart = [
            'count' => count($shoppingCartItems),
            'items' => $shoppingCartItems,
        ];
    @endphp
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
                        <a class="nav-link shoppingCart {{ $shoppingCart['count'] ? 'active' : ''}}" href="javascript:void(0);" data-toggle="modal" data-target="#shoppingCartModal">
                            <span class="oi oi-cart"></span>
                            Корзина
                            <span class="badge badge-warning" style="display: {{ $shoppingCart['count'] ? 'inline-block' : 'none' }};">{{ $shoppingCart['count'] }}</span>
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
                                <button class="btn btn-danger">
                                    <span class="oi oi-trash removeFromCart" title="Убрать из корзины" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-muted">В корзине нет ни одного товара...</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Продолжить покупки</button>
                <button type="button" class="btn btn-primary">Оформить заказ</button>
            </div>
        </div>
    </div>
</div>
<!-- Shopping Cart Modal End -->

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendors/jquery.number.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{ asset('vendors/jquery.preloader.js') }}"></script>
<script type="text/javascript">
    $(function () {

        var generateShoppingCartItems = function (items) {
            var result = $('<div></div>');
            $.each(items, function (idx, value) {
                var $rItem = $('<div class="row mb-2" data-id="' + value.id + '"></div>');
                var $cImage = $('<div class="col-2"><img src="' + value.image + '" alt="' + value.name + '" class="img-thumbnail"></div>');
                var $cName = $('<div class="col-5"><span class="text-dark">' + value.name + '</span></div>');
                var availableClass = value.available > 0 ? 'text-success' : 'text-danger';
                var availableText = value.available > 0 ? 'В наличии' : 'Отсутствует';
                var $cAvailable = $('<div class="col-2"><span class="' + availableClass + '">' + availableText + '</span></div>');
                var $cCount = $('<div class="col-2">Кол-во: <span class="text-dark font-weight-bold">' + value.count + '</span></div>');
                var $cBtn = $('<div class="col-1"><button class="btn btn-danger removeFromCart"><span class="oi oi-trash" title="Убрать из корзины" aria-hidden="true"></span></button></div>');

                $rItem.append($cImage, $cName, $cCount, $cAvailable, $cBtn);
                result.append($rItem);
            });

            return result;
        };
        // Add to shopping cart
        $('.addToCart').on('click', function () {
            var self = this;
            var productId = $(self).data('id');
            var count = 1;
            if (productId.toString() === '{{ $product->id }}') {
                count = $('#productCount').val();
            }

            $(self).closest('.card').preloader('start');
            $.ajax({
                type: 'POST',
                url: '/ajax-add-to-cart/' + productId,
                data: {
                    count: count,
                }
            }).done(function (response) {
                // console.log('Success', response);

                window.shoppingCart = response;
                // Update shopping cart count
                var $badge = $('.navbar .shoppingCart .badge');
                $badge.text(response.count);
                $badge.show();

                // Generate content for shopping cart dialog
                $('#shoppingCartModal .modal-body').empty();
                $('#shoppingCartModal .modal-body').append(generateShoppingCartItems(response.items));


                // Show shopping cart modal dialog
                $('#shoppingCartModal').modal('show');


            }).fail(function (jqXHR, textStatus) {
                console.log('Error', textStatus);
            }).always(function () {
                $(self).closest('.card').preloader('stop');
            });
        });

        // Remove from cart
        $('#shoppingCartModal').on('click', '.removeFromCart', function () {
            var self = this;
            var productId = $(self).closest('.row').data('id');

            $(self).closest('#shoppingCartModal .modal-body').preloader('start');
            $.ajax({
                type: 'POST',
                url: '/ajax-remove-from-cart/' + productId
            }).done(function (response) {
                console.log('Success', response);

                window.shoppingCart = response;

                // Update shopping cart count
                var $badge = $('.navbar .shoppingCart .badge');
                $badge.text(response.count);
                if (response.count > 0) {
                    $badge.show();
                } else {
                    $badge.show();
                }

                // Generate content for shopping cart dialog
                $('#shoppingCartModal .modal-body').empty();
                if (response.count > 0) {
                    $('#shoppingCartModal .modal-body').append(generateShoppingCartItems(response.items));
                } else {
                    $('#shoppingCartModal .modal-body').append($('<p class="text-center text-muted">В корзине нет ни одного товара...</p>'));
                }

            }).fail(function (jqXHR, textStatus) {
                console.log('Error', textStatus);
            }).always(function () {
                $(self).closest('#shoppingCartModal .modal-body').preloader('stop');
            });
        });


        // Scroll Up
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
