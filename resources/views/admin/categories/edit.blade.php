@extends('layouts.admin')

@section('title', 'Редактиорвание категории')
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
                    <h4 class="card-header bg-dark text-light">Редактирование категории</h4>
                    <div class="card-body">

                        <form action="{{ route('admin.categories.update', ['category' => $category]) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label for="inputName">Название</label>
                                <input type="text" name="name" value="{{ $category->name }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="inputName" placeholder="Введите название" autofocus required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <span class="oi oi-circle-check" title="icon circle-check" aria-hidden="true"></span>
                                Сохранить
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">
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
