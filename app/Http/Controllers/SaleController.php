<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\SaleItem;
use App\Services\InventoryService;

class SaleController extends Controller
{
    /**
     * Display listing.
     */
    public function index(Request $request)
    {
        $sales = Sale::query()

            ->with([
                'customer',
                'warehouse',
            ])

            ->when(
                $request->search,
                function ($query, $search) {

                    $query->where(function ($q) use ($search) {

                        $q->where(
                            'reference_no',
                            'like',
                            "%{$search}%"
                        )
                            ->orWhereHas(
                                'customer',
                                function ($customerQuery) use ($search) {

                                    $customerQuery->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    );
                                }
                            );
                    });
                }
            )

            ->latest()

            ->paginate(10)

            ->withQueryString();


        return Inertia::render(
            'sales/Index',
            [
                'sales' => $sales,

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
        return Inertia::render(
            'sales/Create',
            [
                'customers' => Customer::select(
                    'id',
                    'name'
                )
                    ->orderBy('name')
                    ->get(),

                'warehouses' => Warehouse::select(
                    'id',
                    'name'
                )
                    ->orderBy('name')
                    ->get(),

                'products' => Product::select(
                    'id',
                    'name'
                )
                    ->orderBy('name')
                    ->get(),
            ]
        );
    }



    /**
     * Store sale.
     */
    public function store(
        SaleStoreRequest $request,
        InventoryService $inventoryService
    ) {

        DB::transaction(function () use (
            $request,
            $inventoryService
        ) {

            $data = $request->validated();

            $sale = Sale::create([
                'customer_id' => $data['customer_id'],
                'warehouse_id' => $data['warehouse_id'],
                'reference_no' => $data['reference_no'],
                'status' => $data['status'],
                'total_amount' => $data['total_amount'],
                'tax_amount' => $data['tax_amount'] ?? 0,
                'discount_amount' => $data['discount_amount'] ?? 0,
                'paid_amount' => $data['paid_amount'] ?? 0,
                'sale_date' => $data['sale_date'],
                'due_date' => $data['due_date'] ?? null,
                'notes' => $data['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);

            foreach ($data['items'] as $item) {

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'lot_number' => null,
                    'expiry_date' => null,
                ]);

                $inventoryService->decreaseStock(
                    productId: $item['product_id'],
                    warehouseId: $sale->warehouse_id,
                    quantity: $item['quantity'],
                    unitCost: $item['unit_price'],
                    references: [
                        'movement_type' => 'sale',
                        'reference_id' => $sale->id,
                        'sale_id' => $sale->id,
                    ],
                    note: 'Sale : ' . $sale->reference_no,
                );
            }
        });

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Sale created successfully.'
            );
    }



    /**
     * Show sale.
     */
    public function show(
        Sale $sale
    ) {

        $sale->load([
            'customer',
            'warehouse',
            'items.product',
            'payments',
        ]);


        return Inertia::render(
            'sales/Show',
            [
                'sale' => $sale,
            ]
        );
    }



    /**
     * Edit page.
     */
    public function edit(
        Sale $sale
    ) {

        return Inertia::render(
            'sales/Edit',
            [
                'sale' => $sale,

                'customers' => Customer::select(
                    'id',
                    'name'
                )
                    ->orderBy('name')
                    ->get(),

                'warehouses' => Warehouse::select(
                    'id',
                    'name'
                )
                    ->orderBy('name')
                    ->get(),
                    
                'products' => Product::select(
                    'id',
                    'name'
                )
                    ->orderBy('name')
                    ->get(),
            ]
        );
    }



    /**
     * Update sale.
     */
    public function update(
        SaleUpdateRequest $request,
        Sale $sale
    ) {

        $sale->update(
            $request->validated()
        );


        return redirect()

            ->route('sales.index')

            ->with(
                'success',
                'Sale updated successfully.'
            );
    }



    /**
     * Delete sale.
     */
    public function destroy(
        Sale $sale
    ) {

        $sale->delete();


        return redirect()

            ->route('sales.index')

            ->with(
                'success',
                'Sale deleted successfully.'
            );
    }
}
