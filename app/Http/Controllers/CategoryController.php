<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $search = request('search');

        $categories = Category::withTrashed()
            ->with('parent')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('categories/Index', [
            'categories' => $categories,
            'filters' => ['search' => $search],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('categories/Create', [
            'parentCategories' => Category::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        $category = Category::create($request->validated());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): Response
    {
        return Inertia::render('categories/Edit', [
            'category' => $category,
            'parentCategories' => Category::select('id', 'name')
                ->where('id', '<>', $category->id)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
