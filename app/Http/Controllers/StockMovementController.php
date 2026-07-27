<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StockMovementController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = [
            'search' => $request->string('search')->toString(),
            'warehouse_id' => $request->input('warehouse_id'),
            'movement_type' => $request->input('movement_type'),
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
        ];

        $stockMovements = StockMovement::with([
                'product:id,name,sku',
                'warehouse:id,name',
                'creator:id,name',
            ])
            ->when($filters['search'], function ($query, $search) {
                $query->whereHas('product', function ($productQuery) use ($search) {
                    $productQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($filters['warehouse_id'], function ($query, $warehouseId) {
                $query->where('warehouse_id', $warehouseId);
            })
            ->when($filters['movement_type'], function ($query, $movementType) {
                $query->where('movement_type', $movementType);
            })
            ->when($filters['from_date'], function ($query, $fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($filters['to_date'], function ($query, $toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('stock-movements/Index', [
            'stockMovements' => $stockMovements,

            'warehouses' => Warehouse::orderBy('name')
                ->get([
                    'id',
                    'name',
                ]),

            'movementTypes' => [
                'purchase',
                'sale',
                'purchase_return',
                'sale_return',
                'adjustment',
                'transfer_in',
                'transfer_out',
                'manual',
            ],

            'products' => Product::orderBy('name')
                ->get([
                    'id',
                    'name',
                    'sku',
                ]),

            'filters' => $filters,
        ]);
    }
}