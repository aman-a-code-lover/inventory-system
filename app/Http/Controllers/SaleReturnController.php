<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleReturnStoreRequest;
use App\Http\Requests\SaleReturnUpdateRequest;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleReturnController extends Controller
{
    /**
     * Display listing.
     */
    public function index(Request $request)
    {
        $saleReturns = SaleReturn::query()

            ->with([
                'sale',
                'customer',
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
            'sale-returns/Index',
            [
                'saleReturns' => $saleReturns,

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
            'sale-returns/Create',
            [
                'sales' => Sale::select(
                    'id',
                    'reference_no'
                )
                    ->latest()
                    ->get(),


                'customers' => Customer::select(
                    'id',
                    'name'
                )
                    ->orderBy('name')
                    ->get(),
            ]
        );
    }





    /**
     * Store sale return.
     */
    public function store(
        SaleReturnStoreRequest $request
    ) {

        SaleReturn::create(
            $request->validated()
        );


        return redirect()

            ->route('sale-returns.index')

            ->with(
                'success',
                'Sale return created successfully.'
            );
    }





    /**
     * Show.
     */
    public function show(
        SaleReturn $saleReturn
    ) {

        $saleReturn->load([
            'sale',
            'customer',
        ]);


        return Inertia::render(
            'sale-returns/Show',
            [
                'saleReturn' => $saleReturn,
            ]
        );
    }





    /**
     * Edit page.
     */
    public function edit(
        SaleReturn $saleReturn
    ) {

        return Inertia::render(
            'sale-returns/Edit',
            [
                'saleReturn' => $saleReturn,


                'sales' => Sale::select(
                    'id',
                    'reference_no'
                )
                    ->latest()
                    ->get(),


                'customers' => Customer::select(
                    'id',
                    'name'
                )
                    ->orderBy('name')
                    ->get(),
            ]
        );
    }





    /**
     * Update sale return.
     */
    public function update(
        SaleReturnUpdateRequest $request,
        SaleReturn $saleReturn
    ) {

        $saleReturn->update(
            $request->validated()
        );


        return redirect()

            ->route('sale-returns.index')

            ->with(
                'success',
                'Sale return updated successfully.'
            );
    }





    /**
     * Delete sale return.
     */
    public function destroy(
        SaleReturn $saleReturn
    ) {

        $saleReturn->delete();


        return redirect()

            ->route('sale-returns.index')

            ->with(
                'success',
                'Sale return deleted successfully.'
            );
    }
}
