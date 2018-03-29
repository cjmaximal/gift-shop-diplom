@extends('layouts.main')

@section('title', "Каталог - {$category->name}")
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

                {{-- Filter --}}
                <div class="card-header bg-light text-uppercase">
                    <div class="row">
                        {{-- Sort --}}
                        <div class="col-md-3">
                            <div class="btn-group">
                                <a href="{{ route('home.categories.show', [
                            'category' => $category->slug,
                            'dir' => $dir,
                            'sort' => 'price',
                            'page' => $products->currentPage(),
                        ]) }}" class="btn btn-sm font-weight-bold {{ $sort == 'price' ? 'btn-primary ' : 'btn-outline-secondary' }}">
                                    Цена
                                </a>
                                <a href="{{ route('home.categories.show', [
                            'category' => $category->slug,
                            'dir' => $dir,
                            'sort' => 'name',
                            'page' => $products->currentPage(),
                        ]) }}" class="btn btn-sm font-weight-bold {{ $sort == 'name' ? 'btn-primary active' : 'btn-outline-secondary' }}">
                                    Название
                                </a>
                                <a href="{{ route('home.categories.show', [
                            'category' => $category->slug,
                            'dir' => $dir,
                            'sort' => 'created_at',
                            'page' => $products->currentPage(),
                        ]) }}" class="btn btn-sm font-weight-bold {{ $sort == 'created_at' ? 'btn-primary active' : 'btn-outline-secondary' }}">
                                    Дата
                                </a>
                            </div>
                        </div>
                        {{-- Sort End --}}
                        {{-- Direction --}}
                        <div class="col-md-3">
                            <div class="btn-group">
                                <a href="{{ route('home.categories.show', [
                            'category' => $category->slug,
                            'dir' => 'asc',
                            'sort' => $sort,
                            'page' => $products->currentPage(),
                        ]) }}" class="btn btn-sm {{ $dir == 'asc' ? 'btn-primary active' : 'btn-outline-secondary' }}">
                                    <span class="oi oi-caret-top" title="По возрастанию" aria-hidden="true"></span>
                                </a>
                                <a href="{{ route('home.categories.show', [
                            'category' => $category->slug,
                            'dir' => 'desc',
                            'sort' => $sort,
                            'page' => $products->currentPage(),
                        ]) }}" class="btn btn-sm {{ $dir == 'desc' ? 'btn-primary active' : 'btn-outline-secondary' }}">
                                    <span class="oi oi-caret-bottom" title="По убыванию" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                        {{-- Direction End --}}
                    </div>
                </div>
                {{-- Filter End --}}

                {{-- Products --}}
                <div class="card-body">
                    @php
                        $productsBy = 4;
                            if($products->count() % 4 == 1){
                                $productsBy = 3;
                            }
                    @endphp
                    @foreach($products->chunk($productsBy) as $chunk)
                        <div class="card-deck mb-3">
                            @foreach($chunk as $product)
                                <div class="card border-primary col-md-3 p-0">
                                    <a class="custom-link" href="{{ route('home.product.show', ['product' => $product->slug]) }}">
                                        @if($product->images->isNotEmpty())
                                            <img class="card-img-top" src="{{ route('imagecache', [
                                                'template' => 'large',
                                                'filename' => basename($product->images->first()->src),
                                            ]) }}" alt="{{ $product->name }}">
                                        @else
                                            <img class="card-img-top" src="{{ route('imagecache', [
                                                'template' => 'large',
                                                'filename' => 'no-image.png',
                                            ]) }}" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                    <div class="card-body">
                                        <h5 class="text-danger text-center font-weight-bold">
                                            {{ number_format($product->price, 2, ',', ' ') }} &#8381;
                                        </h5>
                                        <a class="custom-link" href="{{ route('home.product.show', ['product' => $product->slug]) }}">
                                            <h6 class="card-title font-weight-bold text-center">{{ $product->name }}</h6>
                                        </a>
                                    </div>
                                    <div class="card-footer bg-primary">
                                        <button type="button" class="btn bg-white text-uppercase btn-sm btn-block addToCart" data-id="{{ $product->id }}">
                                            В корзину
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                {{-- Products End --}}
                <div class="row justify-content-center mt-1">
                    {{ $products->appends(['dir' => $dir, 'sort' => $sort])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
