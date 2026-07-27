<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSupplierStoreRequest;
use App\Http\Requests\ProductSupplierUpdateRequest;
use App\Models\ProductSupplier;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductSupplierController extends Controller
{
    /**
     * Display a listing of product suppliers.
     */
    public function index()
    {
        $productSuppliers = ProductSupplier::with([
            'product',
            'supplier'
        ])
            ->latest()
            ->paginate(10);


        return Inertia::render('product-suppliers/Index', [
            'productSuppliers' => $productSuppliers,
        ]);
    }


    /**
     * Show create page.
     */
    public function create()
    {
        return Inertia::render('product-suppliers/Create', [

            'products' => Product::select('id', 'name')
                ->orderBy('name')
                ->get(),

            'suppliers' => Supplier::select('id', 'name')
                ->orderBy('name')
                ->get(),
        ]);
    }


    /**
     * Store new product supplier.
     */
    public function store(ProductSupplierStoreRequest $request)
    {
        ProductSupplier::create(
            $request->validated()
        );


        return redirect()
            ->route('product-suppliers.index')
            ->with('success', 'Product supplier created successfully.');
    }


    /**
     * Display single product supplier.
     */
    public function show(ProductSupplier $productSupplier)
    {
        $productSupplier->load([
            'product',
            'supplier'
        ]);


        return Inertia::render('product-suppliers/Show', [
            'productSupplier' => $productSupplier,
        ]);
    }


    /**
     * Show edit page.
     */
    public function edit(ProductSupplier $productSupplier)
    {
        return Inertia::render('product-suppliers/Edit', [

            'productSupplier' => $productSupplier,

            'products' => Product::select('id', 'name')
                ->orderBy('name')
                ->get(),

            'suppliers' => Supplier::select('id', 'name')
                ->orderBy('name')
                ->get(),
        ]);
    }


    /**
     * Update product supplier.
     */
    public function update(
        ProductSupplierUpdateRequest $request,
        ProductSupplier $productSupplier
    ) {
        $productSupplier->update(
            $request->validated()
        );


        return redirect()
            ->route('product-suppliers.index')
            ->with('success', 'Product supplier updated successfully.');
    }


    /**
     * Delete product supplier.
     */
    public function destroy(ProductSupplier $productSupplier)
    {
        $productSupplier->delete();


        return redirect()
            ->route('product-suppliers.index')
            ->with('success', 'Product supplier deleted successfully.');
    }
}
