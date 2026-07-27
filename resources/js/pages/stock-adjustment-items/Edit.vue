<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import stockAdjustmentItems from '@/routes/stock-adjustment-items';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface StockAdjustment {
    id: number;
    reference_no: string;
}

interface Product {
    id: number;
    name: string;
    sku: string;
}

interface StockAdjustmentItem {
    id: number;
    stock_adjustment_id: number | null;
    product_id: number | null;
    quantity_before: number;
    quantity_after: number;
    adjustment_quantity: number;
    reason: string | null;
}

const props = defineProps<{
    stockAdjustmentItem: StockAdjustmentItem;
    stockAdjustments: StockAdjustment[];
    products: Product[];
}>();

const form = useForm({
    stock_adjustment_id: props.stockAdjustmentItem.stock_adjustment_id,

    product_id: props.stockAdjustmentItem.product_id,

    quantity_before: props.stockAdjustmentItem.quantity_before,

    quantity_after: props.stockAdjustmentItem.quantity_after,

    adjustment_quantity: props.stockAdjustmentItem.adjustment_quantity,

    reason: props.stockAdjustmentItem.reason ?? '',
});

function submit() {
    form.put(
        stockAdjustmentItems.update.url(
            props.stockAdjustmentItem.id,
        ),
    );
}
</script>

<template>

<Head title="Edit Stock Adjustment Item" />

<form
    class="space-y-8"
    @submit.prevent="submit"
>

<div>

<h1 class="text-2xl font-semibold">
Edit Stock Adjustment Item
</h1>

<p class="text-sm text-muted-foreground">
Update stock adjustment item.
</p>

</div>

<div class="rounded-lg border p-6">

<h2 class="mb-6 text-lg font-semibold">
Item Information
</h2>

<div class="grid gap-6 md:grid-cols-2">

<div class="space-y-2">

<Label>
Stock Adjustment
</Label>

<select
    v-model="form.stock_adjustment_id"
    class="w-full rounded-md border bg-background px-3 py-2"
>

<option :value="null">
Select Adjustment
</option>

<option
    v-for="adjustment in stockAdjustments"
    :key="adjustment.id"
    :value="adjustment.id"
>
{{ adjustment.reference_no }}
</option>

</select>

<InputError :message="form.errors.stock_adjustment_id" />

</div>

<div class="space-y-2">

<Label>
Product
</Label>

<select
    v-model="form.product_id"
    class="w-full rounded-md border bg-background px-3 py-2"
>

<option :value="null">
Select Product
</option>

<option
    v-for="product in products"
    :key="product.id"
    :value="product.id"
>
{{ product.name }} ({{ product.sku }})
</option>

</select>

<InputError :message="form.errors.product_id" />

</div>
        <div class="space-y-2">

            <Label>
                Quantity Before
            </Label>

            <Input
                type="number"
                step="0.0001"
                min="0"
                v-model="form.quantity_before"
            />

            <InputError
                :message="form.errors.quantity_before"
            />

        </div>

        <div class="space-y-2">

            <Label>
                Quantity After
            </Label>

            <Input
                type="number"
                step="0.0001"
                min="0"
                v-model="form.quantity_after"
            />

            <InputError
                :message="form.errors.quantity_after"
            />

        </div>

        <div class="space-y-2">

            <Label>
                Adjustment Quantity
            </Label>

            <Input
                type="number"
                step="0.0001"
                v-model="form.adjustment_quantity"
            />

            <InputError
                :message="form.errors.adjustment_quantity"
            />

        </div>

        <div class="space-y-2 md:col-span-2">

            <Label>
                Reason
            </Label>

            <textarea
                v-model="form.reason"
                rows="4"
                class="w-full rounded-md border bg-background px-3 py-2"
                placeholder="Reason for adjustment..."
            />

            <InputError
                :message="form.errors.reason"
            />

        </div>

    </div>

</div>

<div class="flex justify-end gap-3">

    <Button
        type="button"
        variant="outline"
        @click="$inertia.visit(stockAdjustmentItems.index.url())"
    >
        Cancel
    </Button>

    <Button
        type="submit"
        :disabled="form.processing"
    >
        Update Stock Adjustment Item
    </Button>

</div>

</form>

</template>