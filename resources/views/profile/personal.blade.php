@extends('layouts.main')

@section('title', 'Персональные данные')
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

            <div class="card">
                <h5 class="card-header">Персональные данные</h5>
                <div class="card-body">
                    <form action="{{ route('profile.personal.update') }}" method="POST">
                        @csrf
                        @method('put')
                        {{-- ФИО --}}
                        <div class="form-row mb-3">
                            <div class="form-group col-md-4">
                                <label for="inputPhone">Фамилия</label>
                                <input type="text"
                                       name="surname"
                                       value="{{ old('surname', $user->surname) }}"
                                       class="form-control {{ $errors->has('surname') ? ' is-invalid' : '' }}"
                                       id="inputSurname"
                                       autofocus>
                                @if ($errors->has('surname'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputName" class="font-weight-bold">Имя</label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       id="inputName"
                                       required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPatronymic">Отчество</label>
                                <input type="text"
                                       name="patronymic"
                                       value="{{ old('patronymic', $user->patronymic) }}"
                                       class="form-control {{ $errors->has('patronymic') ? ' is-invalid' : '' }}"
                                       id="inputPatronymic">
                                @if ($errors->has('patronymic'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('patronymic') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{-- Контакты --}}
                        <div class="form-row  mb-3">
                            <div class="form-group col-md-6">
                                <label for="inputPhone">Телефон</label>
                                <input type="text"
                                       name="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                       id="inputPhone"
                                       placeholder="Телефон">
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail" class="font-weight-bold">E-mail</label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       id="inputEmail"
                                       placeholder="E-mail"
                                       required
                                        {{ Auth::user() ? 'readonly' : '' }}>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="d-inline-block">
                            <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                                <span class="oi oi-arrow-left"></span>
                                Назад
                            </a>
                        </div>
                        <div class="d-inline-block float-right">
                            <button type="submit" class="btn btn-primary float-right">
                                <span class="oi oi-circle-check mr-2"></span>
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection