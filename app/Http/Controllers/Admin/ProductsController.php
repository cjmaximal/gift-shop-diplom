<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Image;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Storage;

class ProductsController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id');

        $productsQ = Product::query()->with(['categories', 'images']);

        if ($request->filled('category')) {
            $productsQ->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', (int)$request->get('category'));
            });
        }

        $products = $productsQ->orderBy('name')->paginate($this->perPage);

        return view('admin.products.index', [
            'categories' => $categories,
            'products'   => $products,
        ]);
    }

    public function create()
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id');

        return view('admin.products.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'         => 'required|unique:products|max:255',
            'description'  => 'nullable',
            'price'        => 'required|numeric',
            'is_available' => 'boolean',
        ]);


        $product = (new Product())->fill($validatedData);
        try {
            $product->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.products.create')
                ->withInput()
                ->with('error', 'Ой! Что-то пошло не так...');
        }

        if ($request->filled('categories')) {
            $categoriesIds = Category::query()
                ->whereIn('id', $request->input('categories'))
                ->get()
                ->pluck('id');

            $product->categories()->sync($categoriesIds);
        }


        if ($request->hasFile('images')) {
            $defaultImage = 0;
            foreach ($request->file('images') as $file) {
                $imgName = $product->id . '--' . (string)Str::uuid() . '.' . $file->getClientOriginalExtension();
                try {
                    $path = Storage::disk('public')->putFileAs("images/products", $file, $imgName);

                    $image = new Image();
                    $image->src = $path;
                    $image->is_default = $defaultImage == 0;

                    try {
                        $image->product()->associate($product);
                        $image->save();
                    } catch (\Exception $e) {
                        Storage::disk('public')->delete($path);
                    }

                    $defaultImage++;
                } catch (\Exception $e) {
                    \Log::debug('Save product image', $e->getTrace());
                }
            }
        }

        if ($product->images()->count()) {
            if (!$product->images()->where('is_default', 1)->count()) {
                $image = $product->images()->first();
                $image->is_default = true;
                $image->save();
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('status', "Новый товар <strong>{$product->name}</strong> успешно добавлен!");
    }

    public function edit(Product $product)
    {
        $product->load(['categories', 'images' => function ($q) {
            $q->orderBy('is_default', 'desc');
        }]);

        $categories = Category::query()
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id');

        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name'         => [
                'required',
                Rule::unique('products')->ignore($product->id),
                'max:255',
            ],
            'description'  => 'nullable',
            'price'        => 'required|numeric',
            'is_available' => 'boolean',
        ]);


        $product->fill($validatedData);
        try {
            $product->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.products.edit')
                ->withInput()
                ->with('error', 'Ой! Что-то пошло не так...');
        }

        if ($request->filled('categories')) {
            $categoriesIds = Category::query()
                ->whereIn('id', $request->input('categories'))
                ->get()
                ->pluck('id');

            $product->categories()->sync($categoriesIds);
        }

        if ($request->filled('remove_images')) {
            $product->images()->whereIn('id', $request->input('remove_images'))->delete();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imgName = $product->id . '--' . (string)Str::uuid() . '.' . $file->getClientOriginalExtension();

                try {
                    $path = Storage::disk('public')->putFileAs("images/products", $file, $imgName);

                    $image = new Image();
                    $image->src = $path;
                    $image->is_default = false;

                    try {
                        $image->product()->associate($product);
                        $image->save();
                    } catch (\Exception $e) {
                        Storage::disk('public')->delete($path);
                    }

                } catch (\Exception $e) {
                    \Log::debug('Save product image', $e->getTrace());
                }
            }
        }

        if ($product->images()->count()) {
            $product->images()->update(['is_default' => 0]);
            if (
                $request->filled('default_image') &&
                !in_array($request->input('default_image'), $request->input('remove_images', [])) &&
                $product->images()->where('id', $request->input('default_image'))->count()
            ) {
                $product->images()->where('id', $request->input('default_image'))->update(['is_default' => 1]);
            } else if (!$product->images()->where('is_default', 1)->count()) {
                $image = $product->images()->first();
                $image->is_default = true;
                $image->save();
            } else {
                $product->images()
                    ->where('id', $request->input('default_image'))
                    ->update(['is_default' => 1]);
            }
        }

        $productLink = route('admin.products.edit', ['product' => $product->slug]);
        $statusMessage = "Товар <strong><a href='$productLink'>{$product->name}</a></strong> успешно сохранен!";

        if ($request->input('submit') == 'close') {
            return redirect()
                ->route('admin.products.index')
                ->with('status', $statusMessage);
        }

        return redirect()
            ->back()
            ->with('status', $statusMessage);
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.products.index')
                ->with('error', 'Ой! Что-то пошло не так...');
        }

        return redirect()
            ->route('admin.products.index')
            ->with('status', "Товар <strong>{$product->name}</strong> успешно удален!");
    }
}
