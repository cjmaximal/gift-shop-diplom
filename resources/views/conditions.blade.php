@extends('layouts.main')

@section('title', 'Условия')
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
                <div class="card-header">Условия работы</div>
                <div class="card-body">
                    <h4 class="card-text">
                        <span class="oi oi-warning text-warning"></span>
                        Данный интернет-магазин не осуществляет продажи представленных товаров.
                    </h4>
                    <h5 class="card-text">Сайт интернет-магазина разработан в качестве дипломной работы.</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
