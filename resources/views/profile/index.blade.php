@extends('layouts.main')

@section('title', 'Профиль')
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

            {{-- Personal --}}
            <div class="card">
                <h5 class="card-header">Персональные данные</h5>
                <div class="card-body">
                    <h5 class="card-title">{{ $user->fullName }}</h5>
                    <p class="card-text text-muted">
                        <span class="oi oi-phone"></span>
                        {{ $user->phone }}
                    </p>
                    <p class="card-text text-muted">
                        <span class="oi oi-inbox"></span>
                        {{ $user->email }}
                    </p>
                    <a href="{{ route('profile.personal.edit') }}" class="btn btn-primary float-right">Изменить</a>
                </div>
            </div>
            {{-- Personal End --}}

            {{-- Address --}}
            <div class="card mt-3">
                <h5 class="card-header">Адрес доставки</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <p class="card-text text-muted text-right">Индекс</p>
                        </div>
                        <div class="col-md-10">
                            <p class="card-text text-dark">{{ $user->address_index ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p class="card-text text-muted text-right">Город (н/п)</p>
                        </div>
                        <div class="col-md-10">
                            <p class="card-text text-dark">{{ $user->address_city ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p class="card-text text-muted text-right">Улица</p>
                        </div>
                        <div class="col-md-10">
                            <p class="card-text text-dark">{{ $user->address_street ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p class="card-text text-muted text-right">Дом</p>
                        </div>
                        <div class="col-md-10">
                            <p class="card-text text-dark">{{ $user->address_home ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p class="card-text text-muted text-right">Блок</p>
                        </div>
                        <div class="col-md-10">
                            <p class="card-text text-dark">{{ $user->address_block ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p class="card-text text-muted text-right">Подъезд</p>
                        </div>
                        <div class="col-md-10">
                            <p class="card-text text-dark">{{ $user->address_porch ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <p class="card-text text-muted text-right">Квартира</p>
                        </div>
                        <div class="col-md-10">
                            <p class="card-text text-dark">{{ $user->address_apartment ?? '-' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.address.edit') }}" class="btn btn-primary float-right">Изменить</a>
                </div>
            </div>
            {{-- Address End --}}

            {{-- Orders --}}
            <div class="card mt-3">
                <h5 class="card-header">Заказы</h5>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Товары</th>
                            <th scope="col">Сумма</th>
                            <th scope="col">Статус</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(empty($orders))
                            <tr>
                                <td colspan="6" align="center" class="text-muted">Нет заказов</td>
                            </tr>
                        @else
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $order['date'] }}</td>
                                    <td>
                                        @foreach($order['items'] as $item)
                                            <a href="{{ $item['link'] }}" class="custom-link" target="_blank">
                                                {{ $item['name'] }}
                                            </a>
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>{{ $order['total'] }} &#8381;</td>
                                    <td>{{ $order['status'] }}</td>
                                    <td>
                                        <a href="{{ $order['link'] }}" class="btn btn-primary" title="Подробнее">
                                            <span class="oi oi-external-link"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Orders End --}}

        </div>
    </div>
@endsection