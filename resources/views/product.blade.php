@extends('layouts.main')

@section('title', $product->name)
@section('sidebar')
    <link rel="stylesheet" href="{{ asset('vendors/lightslider/css/lightslider.min.css') }}">
    <script src="{{ asset('vendors/lightslider/js/lightslider.min.js') }}"></script>

    <div class="card border-primary">
        <div class="card-header font-weight-bold text-white bg-primary">
            <span class="oi oi-menu" title="Каталог товаров" aria-hidden="true"></span>
            КАТАЛОГ ТОВАРОВ
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($categories as $categoryItem)
                    <li class="list-group-item {{ Route::current()->parameter('category')->id == $categoryItem->id ? 'active': '' }}">
                        <a class="{{ Route::current()->parameter('category')->id == $categoryItem->id ? 'text-white font-weight-bold': '' }}"
                           href="{{ route('home.categories.show', ['category' => $categoryItem->slug]) }}">
                            {{ $categoryItem->name }}
                        </a>
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
    <div class="row mb-3">
        <div class="col-md-12">

            {{-- Product --}}
            <div class="card border-light" style="box-shadow: rgba(0, 0, 0, .3) 0 0 8px 1px;">

                <div class="card-body">
                    <h2 class="text-center text-primary font-weight-bold">{{ $product->name }}</h2>
                    <hr>

                    <div class="row">
                        {{-- Gallery --}}
                        <div class="col-md-8">
                            <ul id="imageGallery">
                                @if($product->images()->count())
                                    @foreach($product->images as $image)
                                        <li data-thumb="{{ route('imagecache', [
                                                'template' => 'small',
                                                'filename' => basename($image->src),
                                            ]) }}"
                                            data-src="{{ route('imagecache', [
                                                'template' => 'large',
                                                'filename' => basename($image->src),
                                            ]) }}">
                                            <img src="{{ route('imagecache', [
                                                'template' => 'large',
                                                'filename' => basename($image->src),
                                            ]) }}"/>
                                        </li>
                                    @endforeach
                                @else
                                    <li data-thumb="{{ route('imagecache', [
                                                'template' => 'small',
                                                'filename' => 'no-image.png',
                                            ]) }}"
                                        data-src="{{ route('imagecache', [
                                                'template' => 'large',
                                                'filename' => 'no-image.png',
                                            ]) }}">
                                        <img src="{{ route('imagecache', [
                                                'template' => 'large',
                                                'filename' => 'no-image.png',
                                            ]) }}"/>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        {{-- Gallery End --}}
                        {{-- Add to card --}}
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-text">
                                        Цена:&nbsp;
                                        <span class="text-danger font-weight-bold" id="productTotal">
                                            {{ number_format($product->price, 2, ',', ' ') }}
                                        </span>
                                        &nbsp;&#8381;
                                        <input type="hidden" id="productPrice" value="{{ $product->price }}">
                                    </h5>
                                    <div class="form-group">
                                        <label for="productCount">Количество</label>
                                        <input value="1" type="number" min="1" step="1" class="form-control" id="productCount">
                                    </div>
                                    <p class="card-text">
                                        Наличие:&nbsp;
                                        <span class="{{ $product->is_available ? 'text-success' : 'text-muted' }}">
                                            @if($product->is_available)
                                                Имеется
                                            @else
                                                Отсутствует
                                            @endif
                                        </span>
                                    </p>
                                    <p class="card-text">
                                        Категории<br>
                                        @foreach($product->categories as $productCategory)
                                            <span class="badge badge-primary">{{ $productCategory->name }}</span>
                                        @endforeach
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-danger btn-block">В корзину</button>
                                </div>
                            </div>
                        </div>
                        {{-- Add to card End --}}
                    </div>

                    {{-- Description --}}
                    <hr>
                    <h3 class="text-secondary mt-3">Описание</h3>
                    <div class="row">
                        <div class="col-md-12">
                            @if(!empty($product->description))
                                {{ $product->description }}
                            @else
                                <span class="text-muted">Остутствует</span>
                            @endif
                        </div>
                    </div>
                    {{-- Description --}}
                </div>
            </div>
            {{-- Product End --}}

            {{-- Recommendation --}}
            @if($category->products->count())
                <div class="card border-light mt-3" style="box-shadow: rgba(0, 0, 0, .3) 0 0 8px 1px;">
                    <div class="card-body">
                        <h4 class="card-title text-danger mb-4">Рекомендуемые товары</h4>

                        <div class="card-deck mb-3">
                            @foreach($category->products as $product)
                                <div class="card border-primary col-md-3 p-0">
                                    <a class="custom-link" href="{{ route('home.product.show', ['category' => $category->slug, 'product' => $product->slug]) }}">
                                        <img class="card-img-top" src="{{ route('imagecache', [
                                                'template' => 'large',
                                                'filename' => basename($product->images->first()->src),
                                            ]) }}" alt="{{ $product->name }}">
                                    </a>
                                    <div class="card-body">
                                        <h5 class="text-danger text-center font-weight-bold">
                                            {{ number_format($product->price, 2, ',', ' ') }} &#8381;
                                        </h5>
                                        <a class="custom-link" href="{{ route('home.product.show', ['category' => $category->slug, 'product' => $product->slug]) }}">
                                            <h6 class="card-title font-weight-bold text-center">{{ $product->name }}</h6>
                                        </a>
                                        <small class="card-text text-muted">{{ str_limit($product->description, 110) }}</small>
                                    </div>
                                    <div class="card-footer bg-primary">
                                        <button type="button" class="btn bg-white text-uppercase btn-sm btn-block button-add-to-card">
                                            В корзину
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            {{-- Recommendation End --}}
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#productCount').on('input', function () {
                var price = $('#productPrice').val();
                var count = $(this).val();
                var total = price * count;

                $('#productTotal').text($.number(total, 2, ',', ' '));
            });

            $('#imageGallery').lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 4,
                slideMargin: 0,
                enableDrag: false,
                currentPagerPosition: 'left'
            });
        });
    </script>
@endsection
