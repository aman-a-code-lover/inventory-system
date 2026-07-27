<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import purchaseItems from '@/routes/purchase-items';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface PurchaseOption {
    id: number;
    reference_no: string;
}

interface ProductOption {
    id: number;
    name: string;
}

interface PurchaseItem {
    id: number;

    purchase_id: number;

    product_id: number;

    quantity: number;

    unit_price: number;

    tax_amount: number;

    discount_amount: number;

    line_total: number;

    lot_number: string | null;

    expiry_date: string | null;
}

const props = defineProps<{
    purchaseItem: PurchaseItem;

    purchases: PurchaseOption[];

    products: ProductOption[];
}>();

const form = useForm({
    purchase_id: props.purchaseItem.purchase_id,

    product_id: props.purchaseItem.product_id,

    quantity: props.purchaseItem.quantity,

    unit_price: props.purchaseItem.unit_price,

    tax_amount: props.purchaseItem.tax_amount,

    discount_amount: props.purchaseItem.discount_amount,

    line_total: props.purchaseItem.line_total,

    lot_number: props.purchaseItem.lot_number ?? '',

    expiry_date: props.purchaseItem.expiry_date ?? '',
});

function submit() {
    form.put(
        purchaseItems.update.url(props.purchaseItem.id)
    );
}
</script>

<template>

<Head title="Edit Purchase Item" />

<form
    class="space-y-8"
    @submit.prevent="submit"
>

<div>

<h1 class="text-2xl font-semibold">
Edit Purchase Item
</h1>

<p class="text-sm text-muted-foreground">
Update purchase item information.
</p>

</div>
<div class="rounded-lg border p-6">

    <h2 class="mb-6 text-lg font-semibold">
        Purchase Item Information
    </h2>

    <div class="grid gap-6 md:grid-cols-2">

        <div class="space-y-2">

            <Label>
                Purchase
            </Label>

            <select
                v-model="form.purchase_id"
                class="w-full rounded-md border bg-background px-3 py-2"
            >

                <option :value="null">
                    Select Purchase
                </option>

                <option
                    v-for="purchase in purchases"
                    :key="purchase.id"
                    :value="purchase.id"
                >
                    {{ purchase.reference_no }}
                </option>

            </select>

            <InputError :message="form.errors.purchase_id" />

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
                    {{ product.name }}
                </option>

            </select>

            <InputError :message="form.errors.product_id" />

        </div>

        <div class="space-y-2">

            <Label>
                Quantity
            </Label>

            <Input
                type="number"
                step="0.0001"
                min="0"
                v-model="form.quantity"
            />

            <InputError :message="form.errors.quantity" />

        </div>

        <div class="space-y-2">

            <Label>
                Unit Price
            </Label>

            <Input
                type="number"
                step="0.01"
                min="0"
                v-model="form.unit_price"
            />

            <InputError :message="form.errors.unit_price" />

        </div>

        <div class="space-y-2">

            <Label>
                Tax Amount
            </Label>

            <Input
                type="number"
                step="0.01"
                min="0"
                v-model="form.tax_amount"
            />

            <InputError :message="form.errors.tax_amount" />

        </div>

        <div class="space-y-2">

            <Label>
                Discount Amount
            </Label>

            <Input
                type="number"
                step="0.01"
                min="0"
                v-model="form.discount_amount"
            />

            <InputError :message="form.errors.discount_amount" />

        </div>

        <div class="space-y-2">

            <Label>
                Line Total
            </Label>

            <Input
                type="number"
                step="0.01"
                min="0"
                v-model="form.line_total"
            />

            <InputError :message="form.errors.line_total" />

        </div>

        <div class="space-y-2">

            <Label>
                Lot Number
            </Label>

            <Input
                v-model="form.lot_number"
                placeholder="Lot Number"
            />

            <InputError :message="form.errors.lot_number" />

        </div>

        <div class="space-y-2">

            <Label>
                Expiry Date
            </Label>

            <Input
                type="date"
                v-model="form.expiry_date"
            />

            <InputError :message="form.errors.expiry_date" />

        </div>

    </div>

</div>

<div class="flex justify-end gap-3">

    <Button
        type="button"
        variant="outline"
        @click="$inertia.visit(purchaseItems.index.url())"
    >
        Cancel
    </Button>

    <Button
        type="submit"
        :disabled="form.processing"
    >
        Update Purchase Item
    </Button>

</div>

</form>

</template>