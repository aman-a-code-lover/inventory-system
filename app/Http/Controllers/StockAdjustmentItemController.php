<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockAdjustmentItemStoreRequest;
use App\Http\Requests\StockAdjustmentItemUpdateRequest;
use App\Models\Product;
use App\Models\StockAdjustment;
use App\Models\StockAdjustmentItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StockAdjustmentItemController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->string('search');

        $stockAdjustmentItems = StockAdjustmentItem::with([
                'stockAdjustment:id,reference_no',
                'product:id,name,sku',
            ])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($productQuery) use ($search) {
                    $productQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('stock-adjustment-items/Index', [
            'stockAdjustmentItems' => $stockAdjustmentItems,

            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('stock-adjustment-items/Create', [
            'stockAdjustments' => StockAdjustment::orderBy('reference_no')
                ->get([
                    'id',
                    'reference_no',
                ]),

            'products' => Product::orderBy('name')
                ->get([
                    'id',
                    'name',
                    'sku',
                ]),
        ]);
    }

    public function store(
        StockAdjustmentItemStoreRequest $request
    ): RedirectResponse {

        StockAdjustmentItem::create(
            $request->validated()
        );

        return redirect()
            ->route('stock-adjustment-items.index')
            ->with(
                'success',
                'Stock adjustment item created successfully.'
            );
    }

    public function edit(
        StockAdjustmentItem $stockAdjustmentItem
    ): Response
    {
        return Inertia::render('stock-adjustment-items/Edit', [
            'stockAdjustmentItem' => $stockAdjustmentItem,
            'stockAdjustments' => StockAdjustment::orderBy('reference_no')
                ->get([
                    'id',
                    'reference_no',
                ]),

            'products' => Product::orderBy('name')
                ->get([
                    'id',
                    'name',
                    'sku',
                ]),
        ]);
    }

    public function update(
        StockAdjustmentItemUpdateRequest $request,
        StockAdjustmentItem $stockAdjustmentItem
    ): RedirectResponse {

        $stockAdjustmentItem->update(
            $request->validated()
        );

        return redirect()
            ->route('stock-adjustment-items.index')
            ->with(
                'success',
                'Stock adjustment item updated successfully.'
            );
    }

    public function destroy(
        StockAdjustmentItem $stockAdjustmentItem
    ): RedirectResponse {

        $stockAdjustmentItem->delete();

        return redirect()
            ->route('stock-adjustment-items.index')
            ->with(
                'success',
                'Stock adjustment item deleted successfully.'
            );
    }
}