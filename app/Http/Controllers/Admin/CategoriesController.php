<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    private $page = 1;
    private $perPage = 10;

    public function index(Request $request)
    {
        $categories = Category::query()
            ->orderBy('name')
            ->forPage($request->get('page', $this->page), $this->perPage)
            ->get();

        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        $category = (new Category())->fill($validatedData);
        try {
            $category->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.categories.create')
                ->withInput()
                ->with('error', 'Ой! Что-то пошло не так...');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('status', "Новая категория <strong>{$category->name}</strong> успешно добавлена!");
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                Rule::unique('categories', 'name')->ignore($category->id),
                'max:255',
            ],
        ]);

        $category->fill($validatedData);
        try {
            $category->save();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Ой! Что-то пошло не так...');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('status', "Категория <strong>{$category->name}</strong> успешно обновлена!");
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        try {
            $category->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Ой! Что-то пошло не так...');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('status', "Категория <strong>$name</strong> успешно удалена!");
    }
}
