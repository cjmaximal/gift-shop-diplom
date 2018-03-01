@extends('layouts.main')

@section('title', 'Главная')
@section('sidebar')
    <div class="card border-primary">
        <div class="card-header font-weight-bold text-white bg-primary">
            <span class="oi oi-menu" title="Каталог товаров" aria-hidden="true"></span>
            КАТАЛОГ ТОВАРОВ
        </div>

        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($categories as $categoryItem)
                    <li class="list-group-item {{ Route::current()->parameter('category') === $categoryItem->slug }}">
                        <a href="{{ route('home.categories.show', ['category' => $categoryItem->slug]) }}">{{ $categoryItem->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
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
    @php
        $colors = array_random(['primary', 'success', 'warning', 'info', 'danger'], 3);
    @endphp
    @foreach($categoriesProducts as $categoriesProduct)
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card border-{{ $colors[$loop->index] }}">
                    <div class="card-header bg-{{ $colors[$loop->index] }} font-weight-bold text-uppercase">
                        <a class="text-white" href="{{ route('home.categories.show', ['category' => $categoriesProduct['category']->slug]) }}">
                            {{ $categoriesProduct['category']->name }}
                        </a>
                    </div>

                    <div class="card-body">

                        {{-- Products --}}
                        <div class="card-deck">
                            @foreach($categoriesProduct['products'] as $product)
                                <div class="card border-{{ $colors[$loop->parent->index] }}">
                                    <img class="card-img-top" src="{{ route('imagecache', [
                                                'template' => 'medium',
                                                'filename' => basename($product->images->first()->src),
                                            ]) }}" alt="{{ $product->name }}">
                                    <div class="card-body">
                                        <h5 class="text-danger text-center font-weight-bold">
                                            {{ number_format($product->price, 2, ',', ' ') }} &#8381;
                                        </h5>
                                        <h6 class="card-title font-weight-bold text-center">{{ $product->name }}</h6>
                                        <small class="card-text text-muted">{{ str_limit($product->description, 100) }}</small>
                                    </div>
                                    <div class="card-footer bg-{{ $colors[$loop->parent->index] }}">
                                        <button type="button" class="btn bg-white text-uppercase btn-sm btn-block button-add-to-card">
                                            В корзину
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Products End --}}

                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
