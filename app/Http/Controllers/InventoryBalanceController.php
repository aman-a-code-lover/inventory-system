<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryBalanceStoreRequest;
use App\Http\Requests\InventoryBalanceUpdateRequest;
use App\Models\InventoryBalance;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryBalanceController extends Controller
{
    /**
     * Display listing.
     */
    public function index(Request $request)
    {
        $inventoryBalances = InventoryBalance::query()

            ->with([
                'product',
                'warehouse',
            ])

            ->when(
                $request->search,
                function ($query, $search) {

                    $query->whereHas(
                        'product',
                        function ($productQuery) use ($search) {

                            $productQuery->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );
                        }
                    )
                        ->orWhereHas(
                            'warehouse',
                            function ($warehouseQuery) use ($search) {

                                $warehouseQuery->where(
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
            'inventory-balances/Index',
            [
                'inventoryBalances' => $inventoryBalances,

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
            'inventory-balances/Create',
            [
                'products' => Product::select(
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
            ]
        );
    }





    /**
     * Store inventory balance.
     */
    public function store(
        InventoryBalanceStoreRequest $request
    ) {

        InventoryBalance::create(
            $request->validated()
        );


        return redirect()

            ->route('inventory-balances.index')

            ->with(
                'success',
                'Inventory balance created successfully.'
            );
    }





    /**
     * Show.
     */
    public function show(
        InventoryBalance $inventoryBalance
    ) {

        $inventoryBalance->load([
            'product',
            'warehouse',
        ]);


        return Inertia::render(
            'inventory-balances/Show',
            [
                'inventoryBalance' => $inventoryBalance,
            ]
        );
    }





    /**
     * Edit page.
     */
    public function edit(
        InventoryBalance $inventoryBalance
    ) {

        return Inertia::render(
            'inventory-balances/Edit',
            [
                'inventoryBalance' => $inventoryBalance,


                'products' => Product::select(
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
            ]
        );
    }





    /**
     * Update inventory balance.
     */
    public function update(
        InventoryBalanceUpdateRequest $request,
        InventoryBalance $inventoryBalance
    ) {

        $inventoryBalance->update(
            $request->validated()
        );


        return redirect()

            ->route('inventory-balances.index')

            ->with(
                'success',
                'Inventory balance updated successfully.'
            );
    }





    /**
     * Delete inventory balance.
     */
    public function destroy(
        InventoryBalance $inventoryBalance
    ) {

        $inventoryBalance->delete();


        return redirect()

            ->route('inventory-balances.index')

            ->with(
                'success',
                'Inventory balance deleted successfully.'
            );
    }
}
