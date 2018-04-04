@extends('layouts.main')

@section('title', 'Страница не найдена')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="mt-3 text-center">
            <h3>404</h3>
            <h4>Страница не найдена</h4>
        </div>
    </div>
@endsection
