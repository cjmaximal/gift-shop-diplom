@extends('layouts.main')

@section('title', 'Главная')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="mt-3">
            <img src="{{ asset('images/404.png') }}" class="img-fluid" alt="404 Страница не найдена">
        </div>
    </div>
@endsection
