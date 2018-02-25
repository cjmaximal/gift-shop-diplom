@extends('layouts.admin')

@section('title', 'Добавление категории')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card border-dark">
                    <h4 class="card-header bg-dark text-light">Добавление товара</h4>
                    <div class="card-body">

                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Название</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="inputName" value="{{ old('name') }}" placeholder="Введите название" autofocus required>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputDescription" class="col-sm-2 col-form-label">Описание</label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="inputDescription" rows="3" placeholder="Введите описание товара">{{ old('description') }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPrice" class="col-sm-2 col-form-label">Цена (рубль)</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="number" min="0" step="0.01" name="price" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" id="inputPrice" value="{{ old('price', 0) }}" placeholder="Введите цену" aria-label="Цена товара (в рублях)" required>
                                        @if ($errors->has('price'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('price') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="selectIsAvailable" class="col-sm-2 col-form-label">Наличие товара</label>
                                <div class="col-sm-10">
                                    <select name="is_available" class="form-control" id="selectIsAvailable">
                                        <option value="1" selected>Да</option>
                                        <option value="0">Нет</option>
                                    </select>
                                </div>
                            </div>

                            @if(count($categories))
                                <div class="form-group row">
                                    <label for="categoriesChecks" class="col-sm-2 col-form-label">Категории</label>
                                    <div class="col-sm-10">
                                        @foreach($categories as $categoryId => $categoryName)
                                            <div class="form-check custom-control custom-checkbox">
                                                <input name="categories[]" class="form-check-input custom-control-input" type="checkbox" value="{{ $categoryId }}" id="categoryCheck{{ $categoryId }}">
                                                <label class="form-check-label custom-control-label" for="categoryCheck{{ $categoryId }}">
                                                    {{ $categoryName }}
                                                </label>
                                            </div>
                                        @endforeach
                                        @else
                                            <div class="alert alert-warning" role="alert">
                                                Категории отсутствуют!
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="fileImages">Изображения
                                        товара</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="images[]" multiple="multiple" class="form-control-file" accept="image/jpeg,image/png" id="fileImages">
                                        @if ($errors->has('images'))
                                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('images') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <span class="oi oi-check" title="icon check" aria-hidden="true"></span>
                                    Добавить
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark">
                                    <span class="oi oi-x" title="icon x" aria-hidden="true"></span>
                                    Отмена
                                </a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
