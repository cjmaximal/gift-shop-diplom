@extends('layouts.main')

@section('title', 'Адрес доставки')
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
            <div class="card border-light" style="box-shadow: rgba(0, 0, 0, .3) 0 0 8px 1px;">
                <div class="card-body">
                    <form action="{{ route('order.address_store') }}" method="POST">
                        @csrf
                        {{-- ФИО --}}
                        <div class="form-row mb-3">
                            <div class="form-group col-md-4">
                                <label for="inputPhone">Фамилия</label>
                                <input type="text"
                                       name="surname"
                                       value="{{ old('surname') }}"
                                       class="form-control {{ $errors->has('surname') ? ' is-invalid' : '' }}"
                                       id="inputSurname"
                                       placeholder="Иванов"
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
                                       value="{{ old('name') }}"
                                       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       id="inputName"
                                       placeholder="Иван"
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
                                       value="{{ old('patronymic') }}"
                                       class="form-control {{ $errors->has('patronymic') ? ' is-invalid' : '' }}"
                                       id="inputPatronymic"
                                       placeholder="Иванович">
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
                                       value="{{ old('phone') }}"
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
                                       value="{{ old('email') }}"
                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       id="inputEmail"
                                       placeholder="E-mail"
                                       required
                                       autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{-- Адрес --}}
                        <div class="form-row  mb-3">
                            <div class="form-group col-md-4">
                                <label for="inputAddressIndex" class="font-weight-bold">Индекс</label>
                                <input type="text"
                                       name="address_index"
                                       maxlength="6"
                                       value="{{ old('address_index') }}"
                                       class="form-control {{ $errors->has('address_index') ? ' is-invalid' : '' }}"
                                       id="inputAddressIndex"
                                       placeholder="Индекс"
                                       required>
                                @if ($errors->has('address_index'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address_index') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-8">
                                <label for="inputAddressCity" class="font-weight-bold">Город</label>
                                <input type="text"
                                       name="address_city"
                                       class="form-control {{ $errors->has('address_city') ? ' is-invalid' : '' }}"
                                       id="inputAddressCity"
                                       placeholder="Город"
                                       required>
                                @if ($errors->has('address_city'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address_city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row  mb-3">
                            <div class="form-group col-md-4">
                                <label for="inputAddressStreet" class="font-weight-bold">Улица</label>
                                <input type="text"
                                       name="address_street"
                                       value="{{ old('address_street') }}"
                                       class="form-control {{ $errors->has('address_street') ? ' is-invalid' : '' }}"
                                       id="inputAddressStreet"
                                       placeholder="Улица"
                                       required>
                                @if ($errors->has('address_street'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address_street') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputAddressHome" class="font-weight-bold">Дом</label>
                                <input type="text"
                                       name="address_home"
                                       class="form-control {{ $errors->has('address_home') ? ' is-invalid' : '' }}"
                                       id="inputAddressHome"
                                       placeholder="Дом"
                                       required>
                                @if ($errors->has('address_home'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address_home') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputAddressBlock">Корпус</label>
                                <input type="text"
                                       name="address_block"
                                       class="form-control {{ $errors->has('address_block') ? ' is-invalid' : '' }}"
                                       id="inputAddressBlock"
                                       placeholder="Корпус">
                                @if ($errors->has('address_block'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address_block') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputAddressPorch">Подъезд</label>
                                <input type="text"
                                       name="address_porch"
                                       class="form-control {{ $errors->has('address_porch') ? ' is-invalid' : '' }}"
                                       id="inputAddressPorch"
                                       placeholder="Подъезд">
                                @if ($errors->has('address_porch'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address_porch') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputAddressApartment">Квартира</label>
                                <input type="text"
                                       name="address_apartment"
                                       class="form-control {{ $errors->has('address_apartment') ? ' is-invalid' : '' }}"
                                       id="inputAddressApartment"
                                       placeholder="Квартира">
                                @if ($errors->has('address_apartment'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address_apartment') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="textareaComment">Комментарий</label>
                            <textarea class="form-control"
                                      name="comment"
                                      id="textareaComment"
                                      rows="3">
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">
                            <span class="oi oi-circle-check mr-2"></span>
                            Оформить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
