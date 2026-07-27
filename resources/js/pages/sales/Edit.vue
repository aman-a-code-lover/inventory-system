<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';

import sales from '@/routes/sales';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import InputError from '@/components/InputError.vue';



interface Sale {

    id: number;

    customer_id: number | null;

    reference_no: string;

    status: 'draft' | 'completed' | 'cancelled';

    total_amount: number;

    tax_amount: number;

    discount_amount: number;

    paid_amount: number;

    sale_date: string;

    due_date: string | null;

    warehouse_id: number | null;

    notes: string | null;

}



interface CustomerOption {

    id: number;

    name: string;

}



interface WarehouseOption {

    id: number;

    name: string;

}



const props = defineProps<{

    sale: Sale;

    customers: CustomerOption[];

    warehouses: WarehouseOption[];

}>();





const form = useForm({

    customer_id: props.sale.customer_id,

    reference_no: props.sale.reference_no,

    status: props.sale.status,

    total_amount: props.sale.total_amount,

    tax_amount: props.sale.tax_amount,

    discount_amount: props.sale.discount_amount,

    paid_amount: props.sale.paid_amount,

    sale_date: props.sale.sale_date,

    due_date: props.sale.due_date ?? '',

    warehouse_id: props.sale.warehouse_id,

    notes: props.sale.notes ?? '',

});





function submit() {

    form.put(
        sales.update.url(
            props.sale.id
        )
    );

}

</script>


<template>

<Head title="Edit Sale" />


<form
    class="space-y-8"
    @submit.prevent="submit"
>



<div>

<h1 class="text-2xl font-semibold">
Edit Sale
</h1>


<p class="text-sm text-muted-foreground">
Update sale information.
</p>


</div>





<div class="rounded-lg border p-6">


<h2 class="mb-6 text-lg font-semibold">
Sale Information
</h2>




<div class="grid gap-6 md:grid-cols-2">





<div class="space-y-2">

<Label>
Customer
</Label>


<select
    v-model="form.customer_id"
    class="w-full rounded-md border bg-background px-3 py-2"
>


<option :value="null">
Select Customer
</option>


<option
    v-for="customer in customers"
    :key="customer.id"
    :value="customer.id"
>

{{ customer.name }}

</option>


</select>


<InputError
    :message="form.errors.customer_id"
/>


</div>





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
Status
</Label>


<select
    v-model="form.status"
    class="w-full rounded-md border bg-background px-3 py-2"
>


<option value="draft">
Draft
</option>


<option value="completed">
Completed
</option>


<option value="cancelled">
Cancelled
</option>


</select>


<InputError
    :message="form.errors.status"
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
Sale Date
</Label>


<Input
    type="date"
    v-model="form.sale_date"
/>


<InputError
    :message="form.errors.sale_date"
/>


</div>





<div class="space-y-2">

<Label>
Due Date
</Label>


<Input
    type="date"
    v-model="form.due_date"
/>


<InputError
    :message="form.errors.due_date"
/>


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


<InputError
    :message="form.errors.total_amount"
/>


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


<InputError
    :message="form.errors.paid_amount"
/>


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


<InputError
    :message="form.errors.tax_amount"
/>


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


<InputError
    :message="form.errors.discount_amount"
/>


</div>





<div class="space-y-2 md:col-span-2">


<Label>
Notes
</Label>


<textarea

    v-model="form.notes"

    rows="4"

    class="w-full rounded-md border bg-background px-3 py-2"

></textarea>


<InputError
    :message="form.errors.notes"
/>


</div>



</div>


</div>





<div class="flex justify-end gap-3">


<Button

    type="button"

    variant="outline"

    @click="$inertia.visit(
        sales.index.url()
    )"

>

Cancel

</Button>





<Button

    type="submit"

    :disabled="form.processing"

>

Update Sale

</Button>


</div>



</form>


</template>