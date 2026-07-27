<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';

import saleReturns from '@/routes/sale-returns';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import InputError from '@/components/InputError.vue';



interface SaleOption {

    id: number;

    reference_no: string;

}



interface CustomerOption {

    id: number;

    name: string;

}





const {

    sales,

    customers,

} = defineProps<{

    sales: SaleOption[];

    customers: CustomerOption[];

}>();







const form = useForm({

    sale_id: null as number | null,

    customer_id: null as number | null,

    reference_no: '',

    total_amount: 0,

    return_date: '',

    notes: '',

});








function submit() {

    form.post(

        saleReturns.store.url()

    );

}



</script>



<template>


<Head title="Create Sale Return" />



<form

    class="space-y-8"

    @submit.prevent="submit"

>



<div>


<h1 class="text-2xl font-semibold">
Create Sale Return
</h1>


<p class="text-sm text-muted-foreground">
Record customer return.
</p>


</div>







<div class="rounded-lg border p-6">



<h2 class="mb-6 text-lg font-semibold">
Return Information
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

    placeholder="Return reference"

/>



<InputError

    :message="form.errors.reference_no"

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
Return Date
</Label>



<Input

    type="date"

    v-model="form.return_date"

/>



<InputError

    :message="form.errors.return_date"

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

        saleReturns.index.url()

    )"

>

Cancel

</Button>







<Button

    type="submit"

    :disabled="form.processing"

>

Create Sale Return

</Button>





</div>





</form>



</template>