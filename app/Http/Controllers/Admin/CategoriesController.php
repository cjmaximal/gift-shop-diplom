<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $page = 1;
    private $perPage = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $categories = Category::query()
            ->orderBy('name')
            ->forPage($request->get('page', $this->page), $this->perPage);

        return view('admin.category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        $category = Category::create($validatedData);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', "Новая категория <strong>{$category->name}</strong> успешно добавлена!");
    }
}
