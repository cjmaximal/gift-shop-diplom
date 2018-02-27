@extends('layouts.app')

@section('title', 'Главная')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-header font-weight-bold text-white bg-primary">
                        <span class="oi oi-menu" title="Каталог товаров" aria-hidden="true"></span>
                        КАТАЛОГ ТОВАРОВ
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($categories as $category)
                                <li class="list-group-item {{ Route::current()->parameter('category') === $category->slug }}">
                                    <a href="{{ route('home.categories.show', ['category' => $category->id]) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-default">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
