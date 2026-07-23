<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class BrandController extends Controller
{
    public function index(): Response
    {
        $search = request('search');

        $brands = Brand::withTrashed()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('brands/Index', [
            'brands' => $brands,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('brands/Create');
    }

    public function store(BrandStoreRequest $request): RedirectResponse
    {
        Brand::create($request->validated());

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand): Response
    {
        return Inertia::render('brands/Edit', [
            'brand' => $brand,
        ]);
    }

    public function update(BrandUpdateRequest $request, Brand $brand): RedirectResponse
    {
        $brand->update($request->validated());

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
