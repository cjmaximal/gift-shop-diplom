@extends('layouts.admin')

@section('title', 'Редактиорвание пользователя')
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
                    <h4 class="card-header bg-dark text-light">Редактирование пользователя</h4>
                    <div class="card-body">

                        <form action="{{ route('admin.users.update', ['user' => $user]) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label for="inputSurname">Фамилия</label>
                                <input type="text" name="surname" value="{{ old('phone', $user->surname) }}" class="form-control {{ $errors->has('surname') ? ' is-invalid' : '' }}" id="inputSurname">

                                @if ($errors->has('surname'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="font-weight-bold">Имя *</label>
                                <input type="text" name="name" value="{{ old('phone', $user->name) }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="inputName" autofocus required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputPatronymic">Отчество</label>
                                <input type="text" name="patronymic" value="{{ old('phone', $user->patronymic) }}" class="form-control {{ $errors->has('patronymic') ? ' is-invalid' : '' }}" id="inputPatronymic">

                                @if ($errors->has('patronymic'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('patronymic') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="font-weight-bold">E-mail *</label>
                                <input type="email" name="email" value="{{ old('phone', $user->email) }}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="inputEmail">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputPhone" class="font-weight-bold">Телефон *</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="inputPhone">

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_admin" id="checkboxIsAdmin" value="1" {{ $user->isAdmin() ? 'checked' : null }}>
                                <label class="form-check-label" for="checkboxIsAdmin">Да</label>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <span class="oi oi-circle-check" title="icon circle-check" aria-hidden="true"></span>
                                Сохранить
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark float-right">
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
