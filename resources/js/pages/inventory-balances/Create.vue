<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';

import inventoryBalances from '@/routes/inventory-balances';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import InputError from '@/components/InputError.vue';



interface ProductOption {

    id: number;

    name: string;

}



interface WarehouseOption {

    id: number;

    name: string;

}





const {

    products,

    warehouses,

} = defineProps<{

    products: ProductOption[];

    warehouses: WarehouseOption[];

}>();







const form = useForm({

    product_id: null as number | null,

    warehouse_id: null as number | null,

    quantity: 0,

    reserved_quantity: 0,

    last_movement_at: '',

});







function submit() {

    form.post(

        inventoryBalances.store.url()

    );

}

</script>

<template>

<Head title="Create Inventory Balance" />

<form

    class="space-y-8"

    @submit.prevent="submit"

>

<div>

<h1 class="text-2xl font-semibold">
Create Inventory Balance
</h1>

<p class="text-sm text-muted-foreground">
Create inventory balance record.
</p>

</div>

<div class="rounded-lg border p-6">

<h2 class="mb-6 text-lg font-semibold">
Inventory Balance Information
</h2>

<div class="grid gap-6 md:grid-cols-2">

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

<InputError :message="form.errors.product_id" />

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

<InputError :message="form.errors.warehouse_id" />

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

<InputError :message="form.errors.quantity" />

</div>

<div class="space-y-2">

<Label>
Reserved Quantity
</Label>

<Input

    type="number"

    step="0.0001"

    min="0"

    v-model="form.reserved_quantity"

/>

<InputError :message="form.errors.reserved_quantity" />

</div>

<div class="space-y-2 md:col-span-2">

<Label>
Last Movement At
</Label>

<Input

    type="datetime-local"

    v-model="form.last_movement_at"

/>

<InputError :message="form.errors.last_movement_at" />

</div>

</div>

</div>

<div class="flex justify-end gap-3">

<Button

    type="button"

    variant="outline"

    @click="$inertia.visit(
        inventoryBalances.index.url()
    )"

>

Cancel

</Button>

<Button

    type="submit"

    :disabled="form.processing"

>

Create Inventory Balance

</Button>

</div>

</form>

</template>