<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';

import saleReturnItems from '@/routes/sale-return-items';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import InputError from '@/components/InputError.vue';



interface SaleReturnItem {

    id: number;

    sale_return_id: number;

    product_id: number;

    quantity: number;

    unit_price: number;

    reason: string | null;

}



interface SaleReturnOption {

    id: number;

    reference_no: string;

}



interface ProductOption {

    id: number;

    name: string;

}





const props = defineProps<{

    saleReturnItem: SaleReturnItem;

    saleReturns: SaleReturnOption[];

    products: ProductOption[];

}>();







const form = useForm({

    sale_return_id: props.saleReturnItem.sale_return_id,

    product_id: props.saleReturnItem.product_id,

    quantity: props.saleReturnItem.quantity,

    unit_price: props.saleReturnItem.unit_price,

    reason: props.saleReturnItem.reason ?? '',

});







function submit() {

    form.put(

        saleReturnItems.update.url(

            props.saleReturnItem.id

        )

    );

}



</script>



<template>

<Head title="Edit Sale Return Item" />



<form

    class="space-y-8"

    @submit.prevent="submit"

>



<div>


<h1 class="text-2xl font-semibold">
Edit Sale Return Item
</h1>


<p class="text-sm text-muted-foreground">
Update sale return item information.
</p>


</div>







<div class="rounded-lg border p-6">



<h2 class="mb-6 text-lg font-semibold">
Sale Return Item Information
</h2>





<div class="grid gap-6 md:grid-cols-2">







<div class="space-y-2">

<Label>
Sale Return
</Label>



<select

    v-model="form.sale_return_id"

    class="w-full rounded-md border bg-background px-3 py-2"

>


<option :value="null">

Select Sale Return

</option>



<option

    v-for="saleReturn in saleReturns"

    :key="saleReturn.id"

    :value="saleReturn.id"

>

{{ saleReturn.reference_no }}

</option>



</select>



<InputError

    :message="form.errors.sale_return_id"

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

{{ product.name }}

</option>



</select>



<InputError

    :message="form.errors.product_id"

/>


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



<InputError

    :message="form.errors.quantity"

/>


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



<InputError

    :message="form.errors.unit_price"

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

    placeholder="Return reason..."

></textarea>



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

    @click="$inertia.visit(

        saleReturnItems.index.url()

    )"

>

Cancel

</Button>







<Button

    type="submit"

    :disabled="form.processing"

>

Update Sale Return Item

</Button>





</div>





</form>



</template>