@extends('layouts.admin')

@section('title', 'Заказы')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('status') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                            <span aria-hidden="true">&times;</span>
                        </button>
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

                <div class="card border-dark">
                    <h4 class="card-header bg-dark text-white">
                        Заказы
                    </h4>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col">Дата</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Покупатель</th>
                                <th scope="col">Продукты</th>
                                <th scope="col" width="5%">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{ $order['id'] }}</th>
                                    <td>{{ $order['date'] }}</td>
                                    <td>{{ $order['status'] }}</td>
                                    <td>{{ $order['buyer'] }}</td>
                                    <td>
                                        @foreach($order['items'] as $item)
                                            <a href="{{ $item['link'] }}" class="custom-link">{{ $item['name'] }}</a>
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group-sm" role="group" aria-label="Управление">
                                            <a href="{{ route('admin.orders.edit', ['id' => $order['id']]) }}" class="btn btn-primary" role="button">
                                                <span class="oi oi-pencil" title="Редактировать" aria-hidden="true"></span>
                                            </a>
                                            <a href="javascript:remove('{{ $order['id'] }}');" role="button" class="btn btn-danger">
                                                <span class="oi oi-trash" title="Удалить" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <form id="removeId{{ $order['id'] }}" action="{{ route('admin.orders.destroy', ['id' => $order['id']]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function remove(id) {
            if (confirm('Удалить заказ #"' + id + '"?')) {
                document.getElementById('removeId' + id).submit();
            }
        }
    </script>
@endsection
