<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
            ]
        );
    }



    /**
     * Store sale.
     */
    public function store(
        SaleStoreRequest $request
    ) {

        Sale::create(
            $request->validated()
        );


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
