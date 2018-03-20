@extends('layouts.main')

@section('title', 'Корзина')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                                <th scope="col">Наличие</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Количество</th>
                                <th scope="col">Сумма</th>
                                <th scope="col">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shoppingCartItems as $item)
                                <tr data-id="{{ $item['id'] }}">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-thumbnail">
                                    </td>
                                    <td>
                                        <a href="{{ route('home.product.show', ['product' => $item['slug']]) }}">
                                            {{ $item['name'] }}
                                        </a>
                                    </td>
                                    <td>
                                <span class="{{ $item['available'] ? 'text-success' : 'text-danger' }}">
                                    {{ $item['available'] ? 'В наличии' : 'Отсутствует' }}
                                </span>
                                    </td>
                                    <td>{{ number_format($item['price'], 2, ',', ' ') }}&nbsp;&#8381;</td>
                                    <td width="100">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-dark btn-sm" id="productDecrement" data-id="{{ $item['id'] }}">
                                                <span class="oi oi-minus" title="Меньше" aria-hidden="true"></span>
                                            </button>
                                            <input class="text-center" type="text" id="productCount" value="{{ $item['count'] }}" readonly style="width: 50px;">
                                            <button class="btn btn-dark btn-sm" id="productIncrement" data-id="{{ $item['id'] }}">
                                                <span class="oi oi-plus" title="Больше" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </td>
                                    <td>{{ number_format($item['sum'], 2, ',', ' ') }}&nbsp;&#8381;</td>
                                    <td>
                                        <button id="removeFromCart" class="btn btn-danger" data-id="{{ $item['id'] }}">
                                            <span class="oi oi-trash" title="Убрать из корзины" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <h5>
                            <span class="text-primary">Итого:&nbsp;</span>
                            <span id="shoppingCartTotal">{{ number_format(array_sum(array_pluck($shoppingCartItems, 'sum')), 2, ',', ' ') }}</span>&nbsp;&#8381;
                        </h5>
                        <a href="{{ route('order.confirm') }}" class="btn btn-success float-right">
                            <span class="oi oi-check"></span>
                            Оформить заказ
                        </a>
                    @else
                        <h5 class="text-center text-muted">
                            <span class="oi oi-ban"></span>
                            Ваша корзина пуста
                        </h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
