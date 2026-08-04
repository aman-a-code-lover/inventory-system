<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseStoreRequest;
use App\Http\Requests\PurchaseUpdateRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use App\Services\InventoryService;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{

    public function __construct(
        private InventoryService $inventoryService,
    ) {}

    public function index(Request $request): Response
    {
        $search = $request->string('search');

        $purchases = Purchase::with([
            'supplier:id,name',
            'warehouse:id,name',
        ])
            ->when(
                $search,
                fn($query) => $query->where('reference_no', 'like', "%{$search}%")
                    ->orWhereHas(
                        'supplier',
                        fn($supplier) => $supplier->where('name', 'like', "%{$search}%")
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

            'products' => Product::orderBy('name')
                ->get(['id', 'name']),
        ]);
    }

    public function store(
        PurchaseStoreRequest $request
    ): RedirectResponse {

        DB::transaction(function () use ($request) {

            $data = $request->validated();

            /*
        |--------------------------------------------------------------------------
        | Calculate Purchase Totals
        |--------------------------------------------------------------------------
        */

            $subtotal = 0;

            foreach ($data['items'] as $item) {

                $subtotal += (
                    $item['quantity'] *
                    $item['unit_price']
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Create Purchase
        |--------------------------------------------------------------------------
        */

            $purchase = Purchase::create([

                'supplier_id' => $data['supplier_id'],

                'warehouse_id' => $data['warehouse_id'],

                'reference_no' => $data['reference_no'],

                'status' => $data['status'],

                'purchase_date' => $data['purchase_date'],

                'due_date' => $data['due_date'] ?? null,

                'subtotal' => $subtotal,

                'tax_amount' => $data['tax_amount'] ?? 0,

                'discount_amount' => $data['discount_amount'] ?? 0,

                'shipping_amount' => $data['shipping_amount'] ?? 0,

                'paid_amount' => $data['paid_amount'] ?? 0,

                'notes' => $data['notes'] ?? null,

                'created_by' => auth()->id(),

            ]);

            /*
        |--------------------------------------------------------------------------
        | Purchase Items
        |--------------------------------------------------------------------------
        */

            foreach ($data['items'] as $item) {

                $purchaseItem = PurchaseItem::create([

                    'purchase_id' => $purchase->id,

                    'product_id' => $item['product_id'],

                    'quantity' => $item['quantity'],

                    'unit_price' => $item['unit_price'],

                    'tax_amount' => 0,

                    'discount_amount' => 0,

                    'lot_number' => null,

                    'expiry_date' => null,

                    'line_total' => (
                        $item['quantity'] *
                        $item['unit_price']
                    ),

                ]);

                /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

                $this->inventoryService->increaseStock(

                    productId: $purchaseItem->product_id,

                    warehouseId: $purchase->warehouse_id,

                    quantity: (float) $purchaseItem->quantity,

                    unitCost: (float) $purchaseItem->unit_price,

                    references: [

                        'movement_type' => 'purchase',

                        'reference_id' => $purchase->id,

                        'purchase_id' => $purchase->id,

                    ],

                    note: 'Purchase : ' . $purchase->reference_no,

                );
            }
        });

        return redirect()
            ->route('purchases.index')
            ->with(
                'success',
                'Purchase created successfully.'
            );
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
