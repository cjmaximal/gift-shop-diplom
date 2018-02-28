@extends('layouts.main')

@section('title', 'Контакты')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Контакты</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Контакты!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
