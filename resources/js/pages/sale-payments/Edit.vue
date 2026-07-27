<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';

import salePayments from '@/routes/sale-payments';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import InputError from '@/components/InputError.vue';



interface SalePayment {

    id: number;

    sale_id: number;

    amount: number;

    paid_at: string | null;

    method: string | null;

    reference: string | null;

    notes: string | null;

}



interface SaleOption {

    id: number;

    reference_no: string;

}





const props = defineProps<{

    salePayment: SalePayment;

    sales: SaleOption[];

}>();






const form = useForm({

    sale_id: props.salePayment.sale_id,

    amount: props.salePayment.amount,

    paid_at: props.salePayment.paid_at ?? '',

    method: props.salePayment.method ?? '',

    reference: props.salePayment.reference ?? '',

    notes: props.salePayment.notes ?? '',

});







function submit() {

    form.put(
        salePayments.update.url(
            props.salePayment.id
        )
    );

}



</script>


<template>

<Head title="Edit Sale Payment" />



<form

    class="space-y-8"

    @submit.prevent="submit"

>



<div>


<h1 class="text-2xl font-semibold">
Edit Sale Payment
</h1>


<p class="text-sm text-muted-foreground">
Update payment information.
</p>


</div>







<div class="rounded-lg border p-6">



<h2 class="mb-6 text-lg font-semibold">
Payment Information
</h2>




<div class="grid gap-6 md:grid-cols-2">





<div class="space-y-2">

<Label>
Sale
</Label>


<select

    v-model="form.sale_id"

    class="w-full rounded-md border bg-background px-3 py-2"

>


<option :value="null">
Select Sale
</option>



<option

    v-for="sale in sales"

    :key="sale.id"

    :value="sale.id"

>

{{ sale.reference_no }}

</option>



</select>


<InputError
    :message="form.errors.sale_id"
/>


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


<InputError
    :message="form.errors.amount"
/>


</div>







<div class="space-y-2">

<Label>
Paid At
</Label>


<Input

    type="datetime-local"

    v-model="form.paid_at"

/>


<InputError
    :message="form.errors.paid_at"
/>


</div>







<div class="space-y-2">

<Label>
Payment Method
</Label>


<Input

    v-model="form.method"

    placeholder="Cash / Bank / Card"

/>


<InputError
    :message="form.errors.method"
/>


</div>







<div class="space-y-2">

<Label>
Reference
</Label>


<Input

    v-model="form.reference"

    placeholder="Payment reference"

/>


<InputError
    :message="form.errors.reference"
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

    placeholder="Notes..."

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
        salePayments.index.url()
    )"

>

Cancel

</Button>





<Button

    type="submit"

    :disabled="form.processing"

>

Update Sale Payment

</Button>



</div>



</form>



</template>