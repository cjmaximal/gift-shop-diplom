@extends('layouts.admin')

@section('title', 'Категории')
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
                        Категории
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-sm">
                            <span class="oi oi-plus" title="Добавить" aria-hidden="true"></span>
                        </a>
                    </h4>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col">Название</th>
                                <th scope="col">Ярлык</th>
                                <th scope="col" width="5%">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <th scope="row">{{ $category->id }}</th>
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
