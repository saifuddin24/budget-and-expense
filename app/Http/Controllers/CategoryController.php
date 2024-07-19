<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View|Response|Array|String
    {
        $categories = Category::paginate(15);

        return view('category.index', compact('categories'));
    }

    public function create(Request $request): View|Response|Array|String
    {
        return view('category.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());

        $request->session()->flash('category.id', $category->id);

        return redirect()->route('category.index');
    }

    public function show(Request $request, Category $category): View|Response|Array|String
    {
        return view('category.show', compact('category'));
    }

    public function edit(Request $request, Category $category): View|Response|Array|String
    {
        return view('category.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        $request->session()->flash('category.id', $category->id);

        return redirect()->route('category.index');
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        return redirect()->route('category.index');
    }
}
