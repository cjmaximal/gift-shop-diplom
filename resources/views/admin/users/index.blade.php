@extends('layouts.admin')

@section('title', 'Пользователи')
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
                        Пользователи
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">
                            <span class="oi oi-plus" title="Добавить" aria-hidden="true"></span>
                        </a>
                        <span class="ml-4 h6">
                            Фильтр по типу
                            <select name="type" id="filter-type">
                                <option value="all" {{ !request()->has('type') || !request()->filled('type') ? 'selected' : '' }}>Все</option>
                                <option value="0" {{ request()->filled('type') && (bool)request()->get('type') == false ? 'selected' : '' }}>Пользователь</option>
                                <option value="1" {{ request()->filled('type') && (bool)request()->get('type') == true ? 'selected' : '' }}>Администратор</option>
                            </select>
                        </span>
                    </h4>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col">ФИО</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">Администратор</th>
                                <th scope="col" width="5%">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->fullName }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <span class="badge badge-{{ $user->isAdmin() ? 'success' : 'secondary' }}">
                                            {{ $user->isAdmin() ? 'Да' : 'Нет' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group-sm" role="group" aria-label="Управление">
                                            <a href="{{ route('admin.users.edit', ['user' => $user]) }}" class="btn btn-primary" role="button">
                                                <span class="oi oi-pencil" title="Редактировать" aria-hidden="true"></span>
                                            </a>
                                            <a href="javascript:remove('{{ $user->id }}', '{{ $user->fullName }}');" role="button" class="btn btn-danger">
                                                <span class="oi oi-trash" title="Удалить" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <form id="removeId{{ $user->id }}" action="{{ route('admin.users.destroy', ['user' => $user]) }}" method="post">
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
@endsection
@section('script')
    <script type="text/javascript">
        function remove(id, name) {
            if (confirm('Удалить пользователя "' + name + '"?')) {
                document.getElementById('removeId' + id).submit();
            }
        }

        $(document).ready(function () {
            $('#filter-type').select2({
                width: '240px'
            });
        });
    </script>
@endsection