<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleReturnItemStoreRequest;
use App\Http\Requests\SaleReturnItemUpdateRequest;
use App\Models\Product;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleReturnItemController extends Controller
{
    /**
     * Display listing.
     */
    public function index(Request $request)
    {
        $saleReturnItems = SaleReturnItem::query()

            ->with([
                'saleReturn',
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
            'sale-return-items/Index',
            [
                'saleReturnItems' => $saleReturnItems,

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
            'sale-return-items/Create',
            [
                'saleReturns' => SaleReturn::select(
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
     * Store sale return item.
     */
    public function store(
        SaleReturnItemStoreRequest $request
    ) {

        SaleReturnItem::create(
            $request->validated()
        );


        return redirect()

            ->route('sale-return-items.index')

            ->with(
                'success',
                'Sale return item created successfully.'
            );
    }





    /**
     * Show.
     */
    public function show(
        SaleReturnItem $saleReturnItem
    ) {

        $saleReturnItem->load([
            'saleReturn',
            'product',
        ]);


        return Inertia::render(
            'sale-return-items/Show',
            [
                'saleReturnItem' => $saleReturnItem,
            ]
        );
    }





    /**
     * Edit page.
     */
    public function edit(
        SaleReturnItem $saleReturnItem
    ) {

        return Inertia::render(
            'sale-return-items/Edit',
            [
                'saleReturnItem' => $saleReturnItem,


                'saleReturns' => SaleReturn::select(
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
     * Update sale return item.
     */
    public function update(
        SaleReturnItemUpdateRequest $request,
        SaleReturnItem $saleReturnItem
    ) {

        $saleReturnItem->update(
            $request->validated()
        );


        return redirect()

            ->route('sale-return-items.index')

            ->with(
                'success',
                'Sale return item updated successfully.'
            );
    }





    /**
     * Delete sale return item.
     */
    public function destroy(
        SaleReturnItem $saleReturnItem
    ) {

        $saleReturnItem->delete();


        return redirect()

            ->route('sale-return-items.index')

            ->with(
                'success',
                'Sale return item deleted successfully.'
            );
    }
}
