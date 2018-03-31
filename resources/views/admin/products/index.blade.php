@extends('layouts.admin')

@section('title', 'Товары')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! session('status') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card border-dark">
                    <h4 class="card-header bg-dark text-white">
                        Товары
                        <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
                            <span class="oi oi-plus" title="Добавить" aria-hidden="true"></span>
                        </a>
                        <span class="ml-4 h6">
                            Фильтр по категории
                            <select name="category" id="filter-category">
                                <option value="all" {{ !request()->has('category') ? 'selected' : '' }}>Все</option>
                                @foreach($categories as $categoryId => $categoryName)
                                    <option value="{{ $categoryId }}" {{ request()->get('category') == $categoryId ? 'selected' : '' }}>{{ $categoryName }}</option>
                                @endforeach
                            </select>
                        </span>
                    </h4>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col">Изображение</th>
                                <th scope="col">Название</th>
                                <th scope="col">Категории</th>
                                <th scope="col">Ярлык</th>
                                <th scope="col">Описание</th>
                                <th scope="col">Цена</th>
                                <th scope="col">В&nbsp;наличии</th>
                                <th scope="col" width="5%">Операции</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>
                                        @if($product->images->count())
                                            <div class="text-center">
                                                <img src="{{ route('imagecache', [
                                                'template' => 'small',
                                                'filename' => basename($product->images->first()->src),
                                            ]) }}" class="img-thumbnail" alt="{{ $product->name }}">
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <img src="{{ route('imagecache', [
                                                'template' => 'small',
                                                'filename' => 'no-image.png',
                                            ]) }}" class="img-thumbnail" alt="Изображение отсутствует">
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        @if($product->categories)
                                            @foreach($product->categories as $category)
                                                <span class="badge badge-info">{{ $category->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge badge-secondary">Без катеогрии</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->slug }}</td>
                                    <td>{{ str_limit($product->description, 50) }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        <span class="badge badge-{{ $product->is_available ? 'success' : 'danger' }}">
                                            {{ $product->is_available ? 'Да' : 'Нет' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group-sm" role="group" aria-label="Управление">
                                            <a href="{{ route('admin.products.edit', ['product' => $product]) }}" class="btn btn-primary" role="button">
                                                <span class="oi oi-pencil" title="Редактировать" aria-hidden="true"></span>
                                            </a>
                                            <a href="javascript:remove('{{ $product->id }}', '{{ $product->name }}');" role="button" class="btn btn-danger">
                                                <span class="oi oi-trash" title="Удалить" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <form id="removeId{{ $product->id }}" action="{{ route('admin.products.destroy', ['product' => $product]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="row justify-content-center mt-1">
            {{ $products->appends(['category' => request()->get('category')])->links() }}
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#filter-category').select2({
                width: '240px'
            });

            $('#filter-category').change(function () {
                if ($(this).val() !== 'all') {
                    urlInsertParam('category', $(this).val());
                } else {
                    urlInsertParam('category', '');
                }
            });
        });

        function remove(id, name) {
            if (confirm('Удалить товар "' + name + '"?')) {
                document.getElementById('removeId' + id).submit();
            }
        }
    </script>
@endsection
