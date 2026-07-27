<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';

import purchaseReturnItems from '@/routes/purchase-return-items';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';


interface PurchaseReturnOption {
    id: number;
    return_number: string;
}


interface ProductOption {
    id: number;
    name: string;
    sku: string | null;
}


const {
    purchaseReturns,
    products,
} = defineProps<{
    purchaseReturns: PurchaseReturnOption[];
    products: ProductOption[];
}>();


const form = useForm({

    purchase_return_id: null as number | null,

    product_id: null as number | null,

    quantity: 0,

    unit_price: 0,

    reason: '',

});


function submit() {

    form.post(
        purchaseReturnItems.store.url()
    );

}

</script>


<template>

<Head title="Create Purchase Return Item" />


<form
    class="space-y-8"
    @submit.prevent="submit"
>


<div>

<h1 class="text-2xl font-semibold">
Create Purchase Return Item
</h1>

<p class="text-sm text-muted-foreground">
Add product details for purchase return.
</p>

</div>



<div class="rounded-lg border p-6">


<h2 class="mb-6 text-lg font-semibold">
Return Item Information
</h2>



<div class="grid gap-6 md:grid-cols-2">



<div class="space-y-2">

<Label>
Purchase Return
</Label>


<select
    v-model="form.purchase_return_id"
    class="w-full rounded-md border bg-background px-3 py-2"
>


<option :value="null">
Select Purchase Return
</option>


<option
    v-for="item in purchaseReturns"
    :key="item.id"
    :value="item.id"
>

{{ item.return_number }}

</option>


</select>


<InputError
    :message="form.errors.purchase_return_id"
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
<span v-if="product.sku">
({{ product.sku }})
</span>

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
        purchaseReturnItems.index.url()
    )"

>

Cancel

</Button>



<Button

    type="submit"

    :disabled="form.processing"

>

Create Purchase Return Item

</Button>


</div>



</form>


</template>