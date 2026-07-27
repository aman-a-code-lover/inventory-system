<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseReturnItemStoreRequest;
use App\Http\Requests\PurchaseReturnItemUpdateRequest;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseReturnItemController extends Controller
{
    /**
     * Display listing.
     */
    public function index(Request $request)
    {
        $items = PurchaseReturnItem::with([
            'purchaseReturn',
            'product'
        ])
            ->when(
                $request->search,
                function ($query, $search) {
                    $query->whereHas(
                        'product',
                        function ($q) use ($search) {
                            $q->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
                }
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return Inertia::render(
            'purchase-return-items/Index',
            [
                'purchaseReturnItems' => $items,

                'filters' => [
                    'search' => $request->search,
                ],
            ]
        );
    }


    /**
     * Create page.
     */
    public function create()
    {
        return Inertia::render('purchase-return-items/Create', [
            'purchaseReturns' => PurchaseReturn::select(
                'id',
                'reference_no'
            )->get(),

            'products' => Product::select(
                'id',
                'name',
                'sku'
            )->get(),
        ]);
    }


    /**
     * Store.
     */
    public function store(
        PurchaseReturnItemStoreRequest $request
    ) {
        PurchaseReturnItem::create(
            $request->validated()
        );


        return redirect()
            ->route('purchase-return-items.index')
            ->with(
                'success',
                'Purchase return item created successfully.'
            );
    }


    /**
     * Show.
     */
    public function show(
        PurchaseReturnItem $purchaseReturnItem
    ) {
        $purchaseReturnItem->load([
            'purchaseReturn',
            'product'
        ]);


        return Inertia::render(
            'purchase-return-items/Show',
            [
                'item' => $purchaseReturnItem
            ]
        );
    }


    /**
     * Edit page.
     */
    public function edit(
        PurchaseReturnItem $purchaseReturnItem
    ) {
        return Inertia::render(
            'purchase-return-items/Edit',
            [
                'item' => $purchaseReturnItem,

                'purchaseReturns' => PurchaseReturn::select(
                    'id',
                    'return_number'
                )->get(),

                'products' => Product::select(
                    'id',
                    'name',
                    'sku'
                )->get(),
            ]
        );
    }


    /**
     * Update.
     */
    public function update(
        PurchaseReturnItemUpdateRequest $request,
        PurchaseReturnItem $purchaseReturnItem
    ) {
        $purchaseReturnItem->update(
            $request->validated()
        );


        return redirect()
            ->route('purchase-return-items.index')
            ->with(
                'success',
                'Purchase return item updated successfully.'
            );
    }


    /**
     * Delete.
     */
    public function destroy(
        PurchaseReturnItem $purchaseReturnItem
    ) {
        $purchaseReturnItem->delete();


        return redirect()
            ->route('purchase-return-items.index')
            ->with(
                'success',
                'Purchase return item deleted successfully.'
            );
    }
}
