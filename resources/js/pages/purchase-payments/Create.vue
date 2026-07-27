<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import purchasePayments from '@/routes/purchase-payments';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface PurchaseOption {
    id: number;
    reference_no: string;
}

const { purchases } = defineProps<{
    purchases: PurchaseOption[];
}>();

const form = useForm({
    purchase_id: null as number | null,

    amount: 0,

    paid_at: '',

    method: '',

    reference: '',

    notes: '',
});

function submit() {
    form.post(
        purchasePayments.store.url()
    );
}
</script>

<template>

<Head title="Create Purchase Payment" />

<form
    class="space-y-8"
    @submit.prevent="submit"
>

<div>

<h1 class="text-2xl font-semibold">
Create Purchase Payment
</h1>

<p class="text-sm text-muted-foreground">
Record a payment against a purchase.
</p>

</div>

<div class="rounded-lg border p-6">

<h2 class="mb-6 text-lg font-semibold">
Payment Information
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
Amount
</Label>

<Input
    type="number"
    step="0.01"
    min="0"
    v-model="form.amount"
/>

<InputError :message="form.errors.amount" />

</div>
        <div class="space-y-2">

            <Label>
                Paid At
            </Label>

            <Input
                type="datetime-local"
                v-model="form.paid_at"
            />

            <InputError :message="form.errors.paid_at" />

        </div>

        <div class="space-y-2">

            <Label>
                Payment Method
            </Label>

            <Input
                v-model="form.method"
                placeholder="Cash, Bank Transfer, Card..."
            />

            <InputError :message="form.errors.method" />

        </div>

        <div class="space-y-2">

            <Label>
                Reference
            </Label>

            <Input
                v-model="form.reference"
                placeholder="Transaction Reference"
            />

            <InputError :message="form.errors.reference" />

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
        @click="$inertia.visit(purchasePayments.index.url())"
    >
        Cancel
    </Button>

    <Button
        type="submit"
        :disabled="form.processing"
    >
        Create Payment
    </Button>

</div>

</form>

</template>