<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import purchases from '@/routes/purchases';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface Option {
    id: number;
    name: string;
}

interface Purchase {
    id: number;
    supplier_id: number | null;
    warehouse_id: number | null;

    reference_no: string;

    status: string;

    purchase_date: string;
    due_date: string | null;

    subtotal: number;
    tax_amount: number;
    discount_amount: number;
    shipping_amount: number;
    paid_amount: number;

    notes: string | null;
}

const props = defineProps<{
    purchase: Purchase;
    suppliers: Option[];
    warehouses: Option[];
}>();

const form = useForm({
    supplier_id: props.purchase.supplier_id,
    warehouse_id: props.purchase.warehouse_id,

    reference_no: props.purchase.reference_no,

    status: props.purchase.status,

    purchase_date: props.purchase.purchase_date,
    due_date: props.purchase.due_date ?? '',

    subtotal: props.purchase.subtotal,
    tax_amount: props.purchase.tax_amount,
    discount_amount: props.purchase.discount_amount,
    shipping_amount: props.purchase.shipping_amount,
    paid_amount: props.purchase.paid_amount,

    notes: props.purchase.notes ?? '',
});

function submit() {
    form.put(purchases.update.url(props.purchase.id));
}
</script>

<template>

<Head title="Edit Purchase" />

<form
    class="space-y-8"
    @submit.prevent="submit"
>

<div>

    <h1 class="text-2xl font-semibold">
        Edit Purchase
    </h1>

    <p class="text-sm text-muted-foreground">
        Update purchase information.
    </p>

</div>
<div class="rounded-lg border p-6">

    <h2 class="mb-6 text-lg font-semibold">
        Purchase Information
    </h2>

    <div class="grid gap-6 md:grid-cols-2">

        <div class="space-y-2">

            <Label>
                Reference No
            </Label>

            <Input
                v-model="form.reference_no"
                placeholder="PO-0001"
            />

            <InputError :message="form.errors.reference_no" />

        </div>

        <div class="space-y-2">

            <Label>
                Status
            </Label>

            <select
                v-model="form.status"
                class="w-full rounded-md border bg-background px-3 py-2"
            >
                <option value="draft">
                    Draft
                </option>

                <option value="pending">
                    Pending
                </option>

                <option value="received">
                    Received
                </option>

                <option value="cancelled">
                    Cancelled
                </option>

            </select>

            <InputError :message="form.errors.status" />

        </div>

        <div class="space-y-2">

            <Label>
                Supplier
            </Label>

            <select
                v-model="form.supplier_id"
                class="w-full rounded-md border bg-background px-3 py-2"
            >
                <option :value="null">
                    Select Supplier
                </option>

                <option
                    v-for="supplier in suppliers"
                    :key="supplier.id"
                    :value="supplier.id"
                >
                    {{ supplier.name }}
                </option>

            </select>

            <InputError :message="form.errors.supplier_id" />

        </div>

        <div class="space-y-2">

            <Label>
                Warehouse
            </Label>

            <select
                v-model="form.warehouse_id"
                class="w-full rounded-md border bg-background px-3 py-2"
            >
                <option :value="null">
                    Select Warehouse
                </option>

                <option
                    v-for="warehouse in warehouses"
                    :key="warehouse.id"
                    :value="warehouse.id"
                >
                    {{ warehouse.name }}
                </option>

            </select>

            <InputError :message="form.errors.warehouse_id" />

        </div>
                <div class="space-y-2">

            <Label>
                Purchase Date
            </Label>

            <Input
                type="date"
                v-model="form.purchase_date"
            />

            <InputError :message="form.errors.purchase_date" />

        </div>

        <div class="space-y-2">

            <Label>
                Due Date
            </Label>

            <Input
                type="date"
                v-model="form.due_date"
            />

            <InputError :message="form.errors.due_date" />

        </div>

    </div>

</div>

<div class="rounded-lg border p-6">

    <h2 class="mb-6 text-lg font-semibold">
        Amount Details
    </h2>

    <div class="grid gap-6 md:grid-cols-3">

        <div class="space-y-2">

            <Label>
                Subtotal
            </Label>

            <Input
                type="number"
                step="0.01"
                min="0"
                v-model="form.subtotal"
            />

            <InputError :message="form.errors.subtotal" />

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
                Shipping Amount
            </Label>

            <Input
                type="number"
                step="0.01"
                min="0"
                v-model="form.shipping_amount"
            />

            <InputError :message="form.errors.shipping_amount" />

        </div>

        <div class="space-y-2">

            <Label>
                Paid Amount
            </Label>

            <Input
                type="number"
                step="0.01"
                min="0"
                v-model="form.paid_amount"
            />

            <InputError :message="form.errors.paid_amount" />

        </div>

    </div>

</div>

<div class="rounded-lg border p-6">

    <div class="space-y-2">

        <Label>
            Notes
        </Label>

        <textarea
            v-model="form.notes"
            rows="4"
            class="w-full rounded-md border bg-background px-3 py-2"
            placeholder="Purchase notes..."
        />

        <InputError :message="form.errors.notes" />

    </div>

</div>

<div class="flex justify-end gap-3">

    <Button
        type="button"
        variant="outline"
        @click="$inertia.visit(purchases.index.url())"
    >
        Cancel
    </Button>

    <Button
        type="submit"
        :disabled="form.processing"
    >
        Create Purchase
    </Button>

</div>

</form>

</template>