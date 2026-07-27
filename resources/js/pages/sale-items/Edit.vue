<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';

import saleItems from '@/routes/sale-items';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import InputError from '@/components/InputError.vue';



interface SaleItem {

    id: number;

    sale_id: number;

    product_id: number;

    quantity: number;

    unit_price: number;

    tax_amount: number;

    discount_amount: number;

    lot_number: string | null;

    expiry_date: string | null;

}



interface SaleOption {

    id: number;

    reference_no: string;

}



interface ProductOption {

    id: number;

    name: string;

}



const props = defineProps<{

    saleItem: SaleItem;

    sales: SaleOption[];

    products: ProductOption[];

}>();





const form = useForm({

    sale_id: props.saleItem.sale_id,

    product_id: props.saleItem.product_id,

    quantity: props.saleItem.quantity,

    unit_price: props.saleItem.unit_price,

    tax_amount: props.saleItem.tax_amount,

    discount_amount: props.saleItem.discount_amount,

    lot_number: props.saleItem.lot_number ?? '',

    expiry_date: props.saleItem.expiry_date ?? '',

});





function submit() {

    form.put(
        saleItems.update.url(
            props.saleItem.id
        )
    );

}


</script>


<template>

<Head title="Edit Sale Item" />



<form

    class="space-y-8"

    @submit.prevent="submit"

>



<div>


<h1 class="text-2xl font-semibold">
Edit Sale Item
</h1>


<p class="text-sm text-muted-foreground">
Update sale item information.
</p>


</div>







<div class="rounded-lg border p-6">



<h2 class="mb-6 text-lg font-semibold">
Sale Item Information
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







<div class="space-y-2">

<Label>
Lot Number
</Label>


<Input

    v-model="form.lot_number"

    placeholder="Lot number"

/>



<InputError
    :message="form.errors.lot_number"
/>


</div>







<div class="space-y-2">

<Label>
Expiry Date
</Label>


<Input

    type="date"

    v-model="form.expiry_date"

/>



<InputError
    :message="form.errors.expiry_date"
/>


</div>





</div>



</div>







<div class="flex justify-end gap-3">



<Button

    type="button"

    variant="outline"

    @click="$inertia.visit(
        saleItems.index.url()
    )"

>

Cancel

</Button>





<Button

    type="submit"

    :disabled="form.processing"

>

Update Sale Item

</Button>



</div>



</form>



</template>