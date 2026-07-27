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

const {
    stockAdjustments,
    products,
} = defineProps<{
    stockAdjustments: StockAdjustment[];
    products: Product[];
}>();

const form = useForm({
    stock_adjustment_id: null as number | null,

    product_id: null as number | null,

    quantity_before: 0,

    quantity_after: 0,

    adjustment_quantity: 0,

    reason: '',
});

function submit() {
    form.post(stockAdjustmentItems.store.url());
}
</script>

<template>

<Head title="Create Stock Adjustment Item" />

<form
    class="space-y-8"
    @submit.prevent="submit"
>

<div>

<h1 class="text-2xl font-semibold">
Create Stock Adjustment Item
</h1>

<p class="text-sm text-muted-foreground">
Add an item to a stock adjustment.
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

<InputError
    :message="form.errors.stock_adjustment_id"
/>

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

<InputError
    :message="form.errors.product_id"
/>

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
        Create Stock Adjustment Item
    </Button>

</div>

</form>

</template>