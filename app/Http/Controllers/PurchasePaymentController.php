<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchasePaymentStoreRequest;
use App\Http\Requests\PurchasePaymentUpdateRequest;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PurchasePaymentController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search');

        $payments = PurchasePayment::with([
                'purchase:id,reference_no',
                'creator:id,name',
            ])
            ->when(
                $search,
                fn ($query) => $query->whereHas(
                    'purchase',
                    fn ($purchase) => $purchase->where(
                        'reference_no',
                        'like',
                        "%{$search}%"
                    )
                )
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('purchase-payments/Index', [
            'payments' => $payments,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('purchase-payments/Create', [
            'purchases' => Purchase::orderBy('reference_no')
                ->get([
                    'id',
                    'reference_no',
                ]),
        ]);
    }

    public function store(
        PurchasePaymentStoreRequest $request
    ): RedirectResponse {

        PurchasePayment::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('purchase-payments.index')
            ->with(
                'success',
                'Payment created successfully.'
            );
    }

    public function edit(
        PurchasePayment $purchasePayment
    ): Response
    {
        return Inertia::render('purchase-payments/Edit', [
            'payment' => $purchasePayment,
            'purchases' => Purchase::orderBy('reference_no')
                ->get([
                    'id',
                    'reference_no',
                ]),
        ]);
    }

    public function update(
        PurchasePaymentUpdateRequest $request,
        PurchasePayment $purchasePayment
    ): RedirectResponse {

        $purchasePayment->update(
            $request->validated()
        );

        return redirect()
            ->route('purchase-payments.index')
            ->with(
                'success',
                'Payment updated successfully.'
            );
    }

    public function destroy(
        PurchasePayment $purchasePayment
    ): RedirectResponse {

        $purchasePayment->delete();

        return redirect()
            ->route('purchase-payments.index')
            ->with(
                'success',
                'Payment deleted successfully.'
            );
    }
}