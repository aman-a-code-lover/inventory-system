<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';

import purchaseReturnItems from '@/routes/purchase-return-items';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';


interface PurchaseReturnOption {
    id: number;
    reference_no: string;
}


interface ProductOption {
    id: number;
    name: string;
    sku: string | null;
}


interface PurchaseReturnItem {
    id: number;
    purchase_return_id: number;
    product_id: number;
    quantity: number;
    unit_price: number;
    reason: string | null;
}


const {
    item,
    purchaseReturns,
    products,
} = defineProps<{
    item: PurchaseReturnItem;

    purchaseReturns: PurchaseReturnOption[];

    products: ProductOption[];
}>();



const form = useForm({

    purchase_return_id: item.purchase_return_id,

    product_id: item.product_id,

    quantity: item.quantity,

    unit_price: item.unit_price,

    reason: item.reason ?? '',

});



function submit() {

    form.put(
        purchaseReturnItems.update.url(item.id)
    );

}

</script>


<template>

<Head title="Edit Purchase Return Item" />


<form
    class="space-y-8"
    @submit.prevent="submit"
>


<div>

<h1 class="text-2xl font-semibold">
Edit Purchase Return Item
</h1>


<p class="text-sm text-muted-foreground">
Update purchase return item details.
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
    v-for="purchaseReturn in purchaseReturns"
    :key="purchaseReturn.id"
    :value="purchaseReturn.id"
>

{{ purchaseReturn.reference_no }}

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

Update Purchase Return Item

</Button>



</div>



</form>


</template>