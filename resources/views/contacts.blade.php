@extends('layouts.main')

@section('title', 'Контакты')
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
                <div class="card-header">Контакты</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('home.contacts.send') }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputEmail">E-mail</label>
                            <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="inputEmail" value="{{ Auth::check() ? Auth::user()->email : old('email') }}" {{ Auth::check() ? 'readonly' : null }} autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputName">Имя</label>
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="inputName" value="{{ Auth::check() ? Auth::user()->fullName : old('name') }}" {{ Auth::check() ? 'readonly' : null }}>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputMessage">Сообщение</label>
                            <textarea name="message" class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" id="inputMessage">{{ old('message') }}</textarea>

                            @if ($errors->has('message'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! NoCaptcha::display() !!}

                            @if ($errors->has('g-recaptcha-response'))
                                <span class="invalid-feedback" style="display: block;">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">
                            <span class="oi oi-comment-square"></span>
                            Отправить
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
