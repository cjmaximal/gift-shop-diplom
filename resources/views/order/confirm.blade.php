@extends('layouts.main')

@section('title', 'Подтверждение заказа')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card border-light" style="box-shadow: rgba(0, 0, 0, .3) 0 0 8px 1px;">
                <div class="card-body" id="shoppingCartContent">
                    @if(count($shoppingCartItems) > 0)
                        <table class="table table-striped" id="shoppingCartProducts" style="font-size: 12px;">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">Название</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Количество</th>
                                <th scope="col">Сумма</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shoppingCartItems as $item)
                                <tr data-id="{{ $item['id'] }}">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-thumbnail">
                                    </td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ number_format($item['price'], 2, ',', ' ') }}&nbsp;&#8381;</td>
                                    <td>{{ $item['count'] }}</td>
                                    <td>{{ number_format($item['sum'], 2, ',', ' ') }}&nbsp;&#8381;</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <h5>
                            <span class="text-primary">Итого:&nbsp;</span>
                            <span id="shoppingCartTotal">{{ number_format(array_sum(array_pluck($shoppingCartItems, 'sum')), 2, ',', ' ') }}</span>&nbsp;&#8381;
                        </h5>
                        <div class="clearfix mt-5"></div>
                        <div class="d-inline-block">
                            <a href="{{ route('home.shopping_cart') }}" class="btn btn-secondary">
                                <span class="oi oi-arrow-left"></span>
                                Назад
                            </a>
                        </div>
                        <div class="d-inline-block float-right">
                            @guest
                                <a href="{{ route('login', ['redirect' => route('order.confirm')]) }}" class="btn btn-primary">Войти</a>
                            @endguest
                            <a href="{{ route('order.address') }}" class="btn btn-success">
                                @guest
                                    Продолжить без регистрации
                                @else
                                    Продолжить
                                @endguest
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
