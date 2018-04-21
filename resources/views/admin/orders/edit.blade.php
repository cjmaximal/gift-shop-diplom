@extends('layouts.admin')

@section('title', 'Редактиорвание заказа')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card border-dark">
                    <h4 class="card-header bg-dark text-light">Редактирование заказа</h4>
                    <div class="card-body">

                        <form action="{{ route('admin.orders.update', ['id' => $order->id]) }}" method="POST">
                            @method('PUT')
                            @csrf
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
                                    <select name="status" class="form-control" id="selectStatus" style="width: 200px;">
                                        @foreach($statuses as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $order->status ? 'selected' : null }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <span class="oi oi-circle-check" title="icon circle-check" aria-hidden="true"></span>
                                Сохранить
                            </button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark">
                                <span class="oi oi-x" title="icon x" aria-hidden="true"></span>
                                Отмена
                            </a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
