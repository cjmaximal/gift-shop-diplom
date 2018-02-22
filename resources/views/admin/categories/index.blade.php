@extends('layouts.admin')

@section('title', 'Категории')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-dark btn-md btn-block">
                    <span class="oi oi-plus" title="Создать" aria-hidden="true"></span>
                    Создать
                </a>
            </div>
            <div class="col-md-10">

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

                <div class="card border-info">
                    <h5 class="card-header bg-info text-white">Категории</h5>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="col-1">#</th>
                                <th scope="col" class="col-auto">Название</th>
                                <th scope="col" class="col-auto">Ярлык</th>
                                <th scope="col" class="col-1">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <div class="btn-group-sm" role="group" aria-label="Управление">
                                            <a href="{{ route('admin.categories.edit', ['category' => $category]) }}" class="btn btn-primary" role="button">
                                                <span class="oi oi-pencil" title="Редактировать" aria-hidden="true"></span>
                                            </a>
                                            <a href="javascript:remove('{{ $category->id }}', '{{ $category->name }}');" role="button" class="btn btn-danger">
                                                <span class="oi oi-trash" title="Удалить" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <form id="removeId{{ $category->id }}" action="{{ route('admin.categories.destroy', ['category' => $category]) }}" method="post">
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
        function remove(id, name) {
            if (confirm('Удалить категорию "' + name + '"?')) {
                document.getElementById('removeId' + id).submit();
            }
        }
    </script>
@endsection
