<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseItemStoreRequest;
use App\Http\Requests\PurchaseItemUpdateRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\InventoryService;
use Illuminate\Support\Facades\DB;

class PurchaseItemController extends Controller
{
    public function __construct(
        private InventoryService $inventoryService,
    ) {}


    public function index(Request $request): Response
    {
        $search = $request->string('search');

        $purchaseItems = PurchaseItem::with([
                'purchase:id,reference_no',
                'product:id,name',
            ])
            ->when(
                $search,
                fn ($query) => $query->whereHas(
                    'product',
                    fn ($product) => $product->where('name', 'like', "%{$search}%")
                )
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('purchase-items/Index', [
            'purchaseItems' => $purchaseItems,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('purchase-items/Create', [
            'purchases' => Purchase::orderBy('reference_no')
                ->get(['id', 'reference_no']),

            'products' => Product::orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function store(
        PurchaseItemStoreRequest $request
    ): RedirectResponse {

        DB::transaction(function () use ($request) {

            $purchaseItem = PurchaseItem::create(
                $request->validated()
            );

            $purchase = Purchase::findOrFail(
                $purchaseItem->purchase_id
            );

            $this->inventoryService->increaseStock(
                productId: $purchaseItem->product_id,
                warehouseId: $purchase->warehouse_id,
                quantity: (float) $purchaseItem->quantity,
                unitCost: (float) $purchaseItem->unit_cost,
                references: [
                    'movement_type' => 'purchase',
                    'reference_id' => $purchase->id,
                    'purchase_id' => $purchase->id,
                ],
                note: 'Purchase #' . $purchase->reference_no,
            );
        });

        return redirect()
            ->route('purchase-items.index')
            ->with(
                'success',
                'Purchase item created successfully.'
            );
    }

    public function edit(
        PurchaseItem $purchaseItem
    ): Response {
        return Inertia::render('purchase-items/Edit', [
            'purchaseItem' => $purchaseItem,
            'purchases' => Purchase::orderBy('reference_no')
                ->get([
                    'id',
                    'reference_no',
                ]),

            'products' => Product::orderBy('name')
                ->get([
                    'id',
                    'name',
                ]),
        ]);
    }

    public function update(
        PurchaseItemUpdateRequest $request,
        PurchaseItem $purchaseItem
    ): RedirectResponse {
        $purchaseItem->update(
            $request->validated()
        );

        return redirect()
            ->route('purchase-items.index')
            ->with(
                'success',
                'Purchase item updated successfully.'
            );
    }

    public function destroy(
        PurchaseItem $purchaseItem
    ): RedirectResponse {
        $purchaseItem->delete();

        return redirect()
            ->route('purchase-items.index')
            ->with(
                'success',
                'Purchase item deleted successfully.'
            );
    }
}