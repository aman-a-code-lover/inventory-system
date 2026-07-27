<?php

namespace App\Services;

use App\Models\InventoryBalance;
use App\Models\StockMovement;

class InventoryService
{
    public function increaseStock(
        int $productId,
        ?int $warehouseId,
        float $quantity,
        ?float $unitCost = null,
        array $references = [],
        ?string $note = null,
    ): void {

        $inventory = InventoryBalance::firstOrCreate(
            [
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
            ],
            [
                'quantity' => 0,
            ],
        );

        $inventory->increment('quantity', $quantity);

        $inventory->refresh();

        $this->createMovement(
            productId: $productId,
            warehouseId: $warehouseId,
            movementType: $references['movement_type'],
            quantity: $quantity,
            balanceAfter: $inventory->quantity,
            unitCost: $unitCost,
            references: $references,
            note: $note,
        );
    }
    public function decreaseStock(
        int $productId,
        ?int $warehouseId,
        float $quantity,
        ?float $unitCost = null,
        array $references = [],
        ?string $note = null,
    ): void {

        $inventory = InventoryBalance::firstOrCreate(
            [
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
            ],
            [
                'quantity' => 0,
            ],
        );

        /*
         * Optional validation
         *
         * Uncomment if negative stock is not allowed.
         */

        // if ($inventory->quantity < $quantity) {
        //     throw new \Exception(
        //         'Insufficient stock available.'
        //     );
        // }

        $inventory->decrement(
            'quantity',
            $quantity
        );

        $inventory->refresh();

        $this->createMovement(
            productId: $productId,
            warehouseId: $warehouseId,
            movementType: $references['movement_type'],
            quantity: -$quantity,
            balanceAfter: $inventory->quantity,
            unitCost: $unitCost,
            references: $references,
            note: $note,
        );
    }
    private function createMovement(
        int $productId,
        ?int $warehouseId,
        string $movementType,
        float $quantity,
        float $balanceAfter,
        ?float $unitCost = null,
        array $references = [],
        ?string $note = null,
    ): void {

        StockMovement::create([
            'product_id' => $productId,

            'warehouse_id' => $warehouseId,

            'movement_type' => $movementType,

            'reference_id' => $references['reference_id'] ?? null,

            'purchase_id' => $references['purchase_id'] ?? null,

            'sale_id' => $references['sale_id'] ?? null,

            'purchase_return_id' => $references['purchase_return_id'] ?? null,

            'sale_return_id' => $references['sale_return_id'] ?? null,

            'stock_adjustment_id' => $references['stock_adjustment_id'] ?? null,

            'quantity' => $quantity,

            'unit_cost' => $unitCost,

            'balance_after' => $balanceAfter,

            'note' => $note,

            'created_by' => auth()->id(),
        ]);
    }
}