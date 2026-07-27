<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseReturnStoreRequest;
use App\Http\Requests\PurchaseReturnUpdateRequest;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseReturnController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search');

        $purchaseReturns = PurchaseReturn::with([
                'purchase:id,reference_no',
                'supplier:id,name',
                'creator:id,name',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where('reference_no', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('purchase-returns/Index', [
            'purchaseReturns' => $purchaseReturns,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('purchase-returns/Create', [
            'purchases' => Purchase::orderBy('reference_no')
                ->get([
                    'id',
                    'reference_no',
                ]),

            'suppliers' => Supplier::orderBy('name')
                ->get([
                    'id',
                    'name',
                ]),
        ]);
    }

    public function store(
        PurchaseReturnStoreRequest $request
    ): RedirectResponse {

        PurchaseReturn::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('purchase-returns.index')
            ->with(
                'success',
                'Purchase return created successfully.'
            );
    }

    public function edit(
        PurchaseReturn $purchaseReturn
    ): Response
    {
        return Inertia::render('purchase-returns/Edit', [
            'purchaseReturn' => $purchaseReturn,
            'purchases' => Purchase::orderBy('reference_no')
                ->get([
                    'id',
                    'reference_no',
                ]),

            'suppliers' => Supplier::orderBy('name')
                ->get([
                    'id',
                    'name',
                ]),
        ]);
    }

    public function update(
        PurchaseReturnUpdateRequest $request,
        PurchaseReturn $purchaseReturn
    ): RedirectResponse {

        $purchaseReturn->update(
            $request->validated()
        );

        return redirect()
            ->route('purchase-returns.index')
            ->with(
                'success',
                'Purchase return updated successfully.'
            );
    }

    public function destroy(
        PurchaseReturn $purchaseReturn
    ): RedirectResponse {

        $purchaseReturn->delete();

        return redirect()
            ->route('purchase-returns.index')
            ->with(
                'success',
                'Purchase return deleted successfully.'
            );
    }
}