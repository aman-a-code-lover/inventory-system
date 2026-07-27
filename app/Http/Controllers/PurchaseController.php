<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseStoreRequest;
use App\Http\Requests\PurchaseUpdateRequest;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class PurchaseController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search');

        $purchases = Purchase::with([
                'supplier:id,name',
                'warehouse:id,name',
            ])
            ->when(
                $search,
                fn ($query) => $query->where('reference_no', 'like', "%{$search}%")
                    ->orWhereHas(
                        'supplier',
                        fn ($supplier) => $supplier->where('name', 'like', "%{$search}%")
                    )
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('purchases/Index', [
            'purchases' => $purchases,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('purchases/Create', [
            'suppliers' => Supplier::orderBy('name')
                ->get(['id', 'name']),

            'warehouses' => Warehouse::orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function store(PurchaseStoreRequest $request): RedirectResponse
    {
        Purchase::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase created successfully.');
    }

    public function edit(Purchase $purchase): Response
    {
        return Inertia::render('purchases/Edit', [
            'purchase' => $purchase,            
            'suppliers' => Supplier::orderBy('name')
                ->get(['id', 'name']),

            'warehouses' => Warehouse::orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function update(
        PurchaseUpdateRequest $request,
        Purchase $purchase
    ): RedirectResponse {
        $purchase->update($request->validated());

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase updated successfully.');
    }

    public function destroy(
        Purchase $purchase
    ): RedirectResponse {
        $purchase->delete();

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase deleted successfully.');
    }
}