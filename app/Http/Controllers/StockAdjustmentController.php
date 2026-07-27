<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockAdjustmentStoreRequest;
use App\Http\Requests\StockAdjustmentUpdateRequest;
use App\Models\StockAdjustment;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StockAdjustmentController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search');

        $stockAdjustments = StockAdjustment::with([
                'warehouse:id,name',
                'creator:id,name',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where('reference_no', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('stock-adjustments/Index', [
            'stockAdjustments' => $stockAdjustments,

            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('stock-adjustments/Create', [
            'warehouses' => Warehouse::orderBy('name')
                ->get([
                    'id',
                    'name',
                ]),

            'statuses' => [
                'pending',
                'posted',
                'cancelled',
            ],
        ]);
    }

    public function store(
        StockAdjustmentStoreRequest $request
    ): RedirectResponse {

        StockAdjustment::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('stock-adjustments.index')
            ->with(
                'success',
                'Stock adjustment created successfully.'
            );
    }

    public function edit(
        StockAdjustment $stockAdjustment
    ): Response
    {
        return Inertia::render('stock-adjustments/Edit', [
            'stockAdjustment' => $stockAdjustment,
            'warehouses' => Warehouse::orderBy('name')
                ->get([
                    'id',
                    'name',
                ]),

            'statuses' => [
                'pending',
                'posted',
                'cancelled',
            ],
        ]);
    }

    public function update(
        StockAdjustmentUpdateRequest $request,
        StockAdjustment $stockAdjustment
    ): RedirectResponse {

        $stockAdjustment->update(
            $request->validated()
        );

        return redirect()
            ->route('stock-adjustments.index')
            ->with(
                'success',
                'Stock adjustment updated successfully.'
            );
    }

    public function destroy(
        StockAdjustment $stockAdjustment
    ): RedirectResponse {

        $stockAdjustment->delete();

        return redirect()
            ->route('stock-adjustments.index')
            ->with(
                'success',
                'Stock adjustment deleted successfully.'
            );
    }
}