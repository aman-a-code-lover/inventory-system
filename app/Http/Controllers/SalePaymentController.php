<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalePaymentStoreRequest;
use App\Http\Requests\SalePaymentUpdateRequest;
use App\Models\Sale;
use App\Models\SalePayment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalePaymentController extends Controller
{
    /**
     * Display listing.
     */
    public function index(Request $request)
    {
        $salePayments = SalePayment::query()

            ->with([
                'sale',
            ])

            ->when(
                $request->search,
                function ($query, $search) {

                    $query->whereHas(
                        'sale',
                        function ($saleQuery) use ($search) {

                            $saleQuery->where(
                                'reference_no',
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
            'sale-payments/Index',
            [
                'salePayments' => $salePayments,

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
            'sale-payments/Create',
            [
                'sales' => Sale::select(
                    'id',
                    'reference_no'
                )
                    ->latest()
                    ->get(),
            ]
        );
    }



    /**
     * Store payment.
     */
    public function store(
        SalePaymentStoreRequest $request
    ) {

        SalePayment::create(
            $request->validated()
        );


        return redirect()

            ->route('sale-payments.index')

            ->with(
                'success',
                'Sale payment created successfully.'
            );
    }



    /**
     * Show payment.
     */
    public function show(
        SalePayment $salePayment
    ) {

        $salePayment->load([
            'sale',
        ]);


        return Inertia::render(
            'sale-payments/Show',
            [
                'salePayment' => $salePayment,
            ]
        );
    }



    /**
     * Edit page.
     */
    public function edit(
        SalePayment $salePayment
    ) {

        return Inertia::render(
            'sale-payments/Edit',
            [
                'salePayment' => $salePayment,

                'sales' => Sale::select(
                    'id',
                    'reference_no'
                )
                    ->latest()
                    ->get(),
            ]
        );
    }



    /**
     * Update payment.
     */
    public function update(
        SalePaymentUpdateRequest $request,
        SalePayment $salePayment
    ) {

        $salePayment->update(
            $request->validated()
        );


        return redirect()

            ->route('sale-payments.index')

            ->with(
                'success',
                'Sale payment updated successfully.'
            );
    }



    /**
     * Delete payment.
     */
    public function destroy(
        SalePayment $salePayment
    ) {

        $salePayment->delete();


        return redirect()

            ->route('sale-payments.index')

            ->with(
                'success',
                'Sale payment deleted successfully.'
            );
    }
}
