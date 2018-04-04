@extends('layouts.main')

@section('title', 'Просмотр заказа')
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
                <h4 class="card-header">Просмотр заказа</h4>
                <div class="card-body">

                    <div class="form-group row">
                        <p class="col-sm-2 text-right form-text m-0 text-muted">Создан</p>
                        <div class="col-sm-10">
                            <p class="form-text m-0">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-2 text-right form-text m-0 text-muted">Изменен</p>
                        <div class="col-sm-10">
                            <p class="form-text m-0">{{ $order->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-2 text-right form-text m-0 text-muted">Покупатель</p>
                        <div class="col-sm-10">
                            <p class="form-text m-0">{{ $order->full_name }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-2 text-right form-text m-0 text-muted">Телефон</p>
                        <div class="col-sm-10">
                            <p class="form-text m-0">{{ $order->phone }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-2 text-right form-text m-0 text-muted">Товары</p>
                        <div class="col-sm-10">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Цена</th>
                                    <th scope="col">Кол-во</th>
                                    <th scope="col">Сумма</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <a href="{{ $item['link'] }}" target="_blank">{{ $item['name'] }}</a>
                                        </td>
                                        <td>{{ number_format($item['price'], 2, ',', ' ') }} &#8381;</td>
                                        <td>{{ $item['count'] }}</td>
                                        <td>{{ number_format($item['sum'], 2, ',', ' ')}} &#8381;</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-2 text-right form-text m-0 text-muted">Сумма</p>
                        <div class="col-sm-10">
                            <p class="form-text m-0">{{ number_format($order->total, 2, ',', ' ') }} &#8381;</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-2 text-right form-text m-0 text-muted">Адрес</p>
                        <div class="col-sm-10">
                            <p class="form-text m-0">{{ $order->address }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-2 text-right form-text m-0 text-muted">Комментарий</p>
                        <div class="col-sm-10">
                            <p class="form-text m-0">{{ $order->comment }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <p class="col-sm-2 text-right form-text m-0 text-dark">Статус</p>
                        <div class="col-sm-10">
                            <p class="form-text m-0">{{ $statuses[$order->status] }}</p>
                        </div>
                    </div>

                    <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                        <span class="oi oi-arrow-left"></span>
                        Назад
                    </a>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
