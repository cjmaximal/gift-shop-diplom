@extends('layouts.admin')

@section('title', 'Категории')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-info">
                    <h5 class="card-header bg-info text-light">Добавление категории</h5>
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.categories.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="inputName">Название</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="inputName" placeholder="Введите название" autofocus required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success">
                                <span class="oi oi-check" title="icon check" aria-hidden="true"></span>
                                Создать
                            </button>
                            <a href="{{ URL::previous() }}" class="btn btn-outline-dark">
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
