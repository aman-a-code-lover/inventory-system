<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import stockAdjustments from '@/routes/stock-adjustments';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface Warehouse {
    id: number;
    name: string;
}

interface StockAdjustment {
    id: number;
    reference_no: string;
    warehouse_id: number | null;
    reason: string | null;
    total_adjusted: number;
    status: string;
}

const props = defineProps<{
    stockAdjustment: StockAdjustment;
    warehouses: Warehouse[];
    statuses: string[];
}>();

const form = useForm({
    reference_no: props.stockAdjustment.reference_no,

    warehouse_id: props.stockAdjustment.warehouse_id,

    reason: props.stockAdjustment.reason ?? '',

    total_adjusted: props.stockAdjustment.total_adjusted,

    status: props.stockAdjustment.status,
});

function submit() {
    form.put(
        stockAdjustments.update.url(props.stockAdjustment.id)
    );
}
</script>

<template>

<Head title="Edit Stock Adjustment" />

<form
    class="space-y-8"
    @submit.prevent="submit"
>

<div>

<h1 class="text-2xl font-semibold">
Edit Stock Adjustment
</h1>

<p class="text-sm text-muted-foreground">
Update stock adjustment details.
</p>

</div>

<div class="rounded-lg border p-6">

<h2 class="mb-6 text-lg font-semibold">
Adjustment Information
</h2>

<div class="grid gap-6 md:grid-cols-2">

<div class="space-y-2">

<Label>
Reference No
</Label>

<Input
    v-model="form.reference_no"
/>

<InputError
    :message="form.errors.reference_no"
/>

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

<InputError
    :message="form.errors.warehouse_id"
/>

</div>

<div class="space-y-2">

<Label>
Status
</Label>

<select
    v-model="form.status"
    class="w-full rounded-md border bg-background px-3 py-2"
>

<option
    v-for="status in statuses"
    :key="status"
    :value="status"
>
{{ status }}
</option>

</select>

<InputError
    :message="form.errors.status"
/>

</div>
        <div class="space-y-2">

            <Label>
                Total Adjusted
            </Label>

            <Input
                type="number"
                step="0.0001"
                min="0"
                v-model="form.total_adjusted"
            />

            <InputError
                :message="form.errors.total_adjusted"
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
        @click="$inertia.visit(stockAdjustments.index.url())"
    >
        Cancel
    </Button>

    <Button
        type="submit"
        :disabled="form.processing"
    >
        Update Stock Adjustment
    </Button>

</div>

</form>

</template>