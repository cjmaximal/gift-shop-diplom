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

            <div class="card">
                <h5 class="card-header">Адрес доставки</h5>
                <div class="card-body">
                    <form action="{{ route('profile.address.update') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-row  mb-3">
                            <div class="form-group col-md-4">
                                <label for="inputAddressIndex" class="font-weight-bold">Индекс</label>
                                <input type="text"
                                       name="address_index"
                                       maxlength="6"
                                       value="{{ old('address_index', $user->address_index) }}"
                                       class="form-control {{ $errors->has('address_index') ? ' is-invalid' : '' }}"
                                       id="inputAddressIndex"
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
                                       value="{{ old('address_city', $user->address_city) }}"
                                       class="form-control {{ $errors->has('address_city') ? ' is-invalid' : '' }}"
                                       id="inputAddressCity"
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
                                       value="{{ old('address_street', $user->address_street) }}"
                                       class="form-control {{ $errors->has('address_street') ? ' is-invalid' : '' }}"
                                       id="inputAddressStreet"
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
                                       value="{{ old('address_home', $user->address_home) }}"
                                       class="form-control {{ $errors->has('address_home') ? ' is-invalid' : '' }}"
                                       id="inputAddressHome"
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
                                       value="{{ old('address_block', $user->address_block) }}"
                                       class="form-control {{ $errors->has('address_block') ? ' is-invalid' : '' }}"
                                       id="inputAddressBlock">
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
                                       value="{{ old('address_porch', $user->address_porch) }}"
                                       class="form-control {{ $errors->has('address_porch') ? ' is-invalid' : '' }}"
                                       id="inputAddressPorch">
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
                                       value="{{ old('address_apartment', $user->address_apartment) }}"
                                       class="form-control {{ $errors->has('address_apartment') ? ' is-invalid' : '' }}"
                                       id="inputAddressApartment">
                                @if ($errors->has('address_apartment'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address_apartment') }}</strong>
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