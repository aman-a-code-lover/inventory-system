<script setup lang="ts">

import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import inventoryBalances from '@/routes/inventory-balances';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';



const page = usePage();



const props = page.props as {

    inventoryBalances: any;

    filters: {
        search?: string;
    };

};





const form = useForm({

    search: props.filters?.search || '',

});





const inventoryBalancesData = computed(
    () => props.inventoryBalances
);







function submitSearch() {

    form.get(

        inventoryBalances.index.url({

            query: {

                search: form.search,

            },

        }),

        {

            preserveState: true,

            replace: true,

        },

    );

}







function resetSearch() {

    form.search = '';

    submitSearch();

}







function deleteInventoryBalance(
    item: { id: number }
) {

    if (
        !confirm(
            'Are you sure you want to delete this inventory balance?'
        )
    ) {

        return;

    }



    router.delete(

        inventoryBalances.destroy.url(item.id),

        {

            preserveState: true,

        },

    );

}



</script>



<template>

<Head title="Inventory Balances" />



<div class="space-y-6">



<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">



<div>

<h1 class="text-2xl font-semibold">
Inventory Balances
</h1>

<p class="text-sm text-muted-foreground">
Manage inventory balances.
</p>

</div>





<div class="flex flex-col gap-2 sm:flex-row sm:items-center">



<form

    class="flex items-center gap-2"

    @submit.prevent="submitSearch"

>

<Label>
Search
</Label>

<Input

    v-model="form.search"

    placeholder="Product / Warehouse"

/>

<Button type="submit">
Search
</Button>

<Button

    type="button"

    variant="secondary"

    @click="resetSearch"

>
Reset
</Button>

</form>





<Link :href="inventoryBalances.create.url()">

<Button>
New Inventory Balance
</Button>

</Link>

</div>

</div>





<div class="overflow-hidden rounded-lg border bg-card">

<table class="min-w-full divide-y divide-border">

<thead class="bg-muted">

<tr>

<th class="px-4 py-3 text-left">
Product
</th>

<th class="px-4 py-3 text-left">
Warehouse
</th>

<th class="px-4 py-3 text-left">
Quantity
</th>

<th class="px-4 py-3 text-left">
Reserved
</th>

<th class="px-4 py-3 text-left">
Last Movement
</th>

<th class="px-4 py-3 text-right">
Actions
</th>

</tr>

</thead>

<tbody class="divide-y divide-border">

<tr

    v-for="inventoryBalance in inventoryBalancesData.data"

    :key="inventoryBalance.id"

>

<td class="px-4 py-4">

{{ inventoryBalance.product?.name ?? '-' }}

</td>

<td class="px-4 py-4">

{{ inventoryBalance.warehouse?.name ?? '-' }}

</td>

<td class="px-4 py-4">

{{ inventoryBalance.quantity }}

</td>

<td class="px-4 py-4">

{{ inventoryBalance.reserved_quantity }}

</td>

<td class="px-4 py-4">

{{ inventoryBalance.last_movement_at ?? '-' }}

</td>

<td class="px-4 py-4 text-right">

<Link

    :href="inventoryBalances.edit.url(inventoryBalance.id)"

    class="text-primary underline"

>

Edit

</Link>

<button

    type="button"

    class="ml-4 text-red-600 underline"

    @click="deleteInventoryBalance(inventoryBalance)"

>

Delete

</button>

</td>

</tr>

</tbody>

</table>

</div>





<div class="flex items-center justify-between">

<div class="text-sm text-muted-foreground">

Showing

{{ inventoryBalancesData.from }}

to

{{ inventoryBalancesData.to }}

of

{{ inventoryBalancesData.total }}

inventory balances

</div>

<div class="flex gap-2">

<Link

    v-if="inventoryBalancesData.prev_page_url"

    :href="inventoryBalancesData.prev_page_url"

>

<Button variant="secondary">

Previous

</Button>

</Link>

<Link

    v-if="inventoryBalancesData.next_page_url"

    :href="inventoryBalancesData.next_page_url"

>

<Button variant="secondary">

Next

</Button>

</Link>

</div>

</div>

</div>

</template>