@extends('layouts.admin')

@section('title', 'Категории')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-dark btn-md btn-block">
                    <span class="oi oi-plus" title="icon plus" aria-hidden="true"></span>
                    Создать
                </a>
            </div>
            <div class="col-md-10">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {!! session('status') !!}
                    </div>
                @endif

                <div class="card border-info">
                    <h5 class="card-header bg-info">Категории</h5>
                    <div class="card-body">
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
