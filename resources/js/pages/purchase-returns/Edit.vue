<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import purchaseReturns from '@/routes/purchase-returns';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface PurchaseOption {
    id: number;
    reference_no: string;
}

interface SupplierOption {
    id: number;
    name: string;
}

interface PurchaseReturn {
    id: number;

    purchase_id: number | null;

    supplier_id: number | null;

    reference_no: string;

    total_amount: number;

    return_date: string;

    notes: string | null;
}

const props = defineProps<{
    purchaseReturn: PurchaseReturn;

    purchases: PurchaseOption[];

    suppliers: SupplierOption[];
}>();

const form = useForm({
    purchase_id: props.purchaseReturn.purchase_id,

    supplier_id: props.purchaseReturn.supplier_id,

    reference_no: props.purchaseReturn.reference_no,

    total_amount: props.purchaseReturn.total_amount,

    return_date: props.purchaseReturn.return_date,

    notes: props.purchaseReturn.notes ?? '',
});

function submit() {
    form.put(
        purchaseReturns.update.url(props.purchaseReturn.id)
    );
}
</script>

<template>

<Head title="Edit Purchase Return" />

<form
    class="space-y-8"
    @submit.prevent="submit"
>

<div>

<h1 class="text-2xl font-semibold">
Edit Purchase Return
</h1>

<p class="text-sm text-muted-foreground">
Update supplier return details.
</p>

</div>

<div class="rounded-lg border p-6">

<h2 class="mb-6 text-lg font-semibold">
Return Information
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
                Reference No
            </Label>

            <Input
                v-model="form.reference_no"
                placeholder="Return Reference"
            />

            <InputError :message="form.errors.reference_no" />

        </div>

        <div class="space-y-2">

            <Label>
                Total Amount
            </Label>

            <Input
                type="number"
                step="0.01"
                min="0"
                v-model="form.total_amount"
            />

            <InputError :message="form.errors.total_amount" />

        </div>

        <div class="space-y-2">

            <Label>
                Return Date
            </Label>

            <Input
                type="date"
                v-model="form.return_date"
            />

            <InputError :message="form.errors.return_date" />

        </div>

        <div class="space-y-2 md:col-span-2">

            <Label>
                Notes
            </Label>

            <textarea
                v-model="form.notes"
                rows="4"
                class="w-full rounded-md border bg-background px-3 py-2"
                placeholder="Notes..."
            />

            <InputError :message="form.errors.notes" />

        </div>

    </div>

</div>

<div class="flex justify-end gap-3">

    <Button
        type="button"
        variant="outline"
        @click="$inertia.visit(purchaseReturns.index.url())"
    >
        Cancel
    </Button>

    <Button
        type="submit"
        :disabled="form.processing"
    >
        Update Purchase Return
    </Button>

</div>

</form>

</template>