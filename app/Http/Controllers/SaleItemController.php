<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleItemStoreRequest;
use App\Http\Requests\SaleItemUpdateRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleItemController extends Controller
{
    /**
     * Display listing.
     */
    public function index(Request $request)
    {
        $saleItems = SaleItem::query()

            ->with([
                'sale',
                'product',
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
                    );
                }
            )

            ->latest()

            ->paginate(10)

            ->withQueryString();


        return Inertia::render(
            'sale-items/Index',
            [
                'saleItems' => $saleItems,

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
            'sale-items/Create',
            [
                'sales' => Sale::select(
                    'id',
                    'reference_no'
                )
                    ->latest()
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
     * Store sale item.
     */
    public function store(
        SaleItemStoreRequest $request
    ) {

        SaleItem::create(
            $request->validated()
        );


        return redirect()

            ->route('sale-items.index')

            ->with(
                'success',
                'Sale item created successfully.'
            );
    }



    /**
     * Show.
     */
    public function show(
        SaleItem $saleItem
    ) {

        $saleItem->load([
            'sale',
            'product',
        ]);


        return Inertia::render(
            'sale-items/Show',
            [
                'saleItem' => $saleItem,
            ]
        );
    }



    /**
     * Edit page.
     */
    public function edit(
        SaleItem $saleItem
    ) {

        return Inertia::render(
            'sale-items/Edit',
            [
                'saleItem' => $saleItem,

                'sales' => Sale::select(
                    'id',
                    'reference_no'
                )
                    ->latest()
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
     * Update sale item.
     */
    public function update(
        SaleItemUpdateRequest $request,
        SaleItem $saleItem
    ) {

        $saleItem->update(
            $request->validated()
        );


        return redirect()

            ->route('sale-items.index')

            ->with(
                'success',
                'Sale item updated successfully.'
            );
    }



    /**
     * Delete sale item.
     */
    public function destroy(
        SaleItem $saleItem
    ) {

        $saleItem->delete();


        return redirect()

            ->route('sale-items.index')

            ->with(
                'success',
                'Sale item deleted successfully.'
            );
    }
}
