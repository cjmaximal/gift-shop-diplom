@extends('layouts.main')

@section('title', 'Метод запрещен')
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
            <h3>405</h3>
            <h4>Метод запрещен</h4>
        </div>
    </div>
@endsection
