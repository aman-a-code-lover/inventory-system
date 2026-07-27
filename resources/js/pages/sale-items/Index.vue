<script setup lang="ts">

import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import saleItems from '@/routes/sale-items';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';



const page = usePage();



const props = page.props as {

    saleItems: any;

    filters: {
        search?: string;
    };

};



const form = useForm({

    search: props.filters?.search || '',

});



const saleItemsData = computed(
    () => props.saleItems
);




function submitSearch() {

    form.get(
        saleItems.index.url({
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





function deleteSaleItem(
    item: { id: number }
) {

    if (
        !confirm(
            'Are you sure you want to delete this sale item?'
        )
    ) {
        return;
    }


    router.delete(
        saleItems.destroy.url(item.id),
        {
            preserveState: true,
        },
    );

}



</script>


<template>

<Head title="Sale Items" />


<div class="space-y-6">



<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">



<div>

<h1 class="text-2xl font-semibold">
Sale Items
</h1>


<p class="text-sm text-muted-foreground">
Manage sale items.
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

    placeholder="Product name"

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





<Link :href="saleItems.create.url()">


<Button>
New Sale Item
</Button>


</Link>



</div>


</div>





<div class="overflow-hidden rounded-lg border bg-card">


<table class="min-w-full divide-y divide-border">


<thead class="bg-muted">


<tr>

<th class="px-4 py-3 text-left">
Sale
</th>


<th class="px-4 py-3 text-left">
Product
</th>


<th class="px-4 py-3 text-left">
Quantity
</th>


<th class="px-4 py-3 text-left">
Unit Price
</th>


<th class="px-4 py-3 text-left">
Lot Number
</th>


<th class="px-4 py-3 text-right">
Actions
</th>


</tr>


</thead>





<tbody class="divide-y divide-border">


<tr

    v-for="item in saleItemsData.data"

    :key="item.id"

>


<td class="px-4 py-4">

{{ item.sale?.reference_no ?? '-' }}

</td>



<td class="px-4 py-4">

{{ item.product?.name ?? '-' }}

</td>



<td class="px-4 py-4">

{{ item.quantity }}

</td>



<td class="px-4 py-4">

{{ item.unit_price }}

</td>



<td class="px-4 py-4">

{{ item.lot_number ?? '-' }}

</td>




<td class="px-4 py-4 text-right">


<Link

    :href="saleItems.edit.url(item.id)"

    class="text-primary underline"

>

Edit

</Link>




<button

    type="button"

    class="ml-4 text-red-600 underline"

    @click="deleteSaleItem(item)"

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

{{ saleItemsData.from }}

to

{{ saleItemsData.to }}

of

{{ saleItemsData.total }}

sale items


</div>





<div class="flex gap-2">



<Link

    v-if="saleItemsData.prev_page_url"

    :href="saleItemsData.prev_page_url"

>


<Button variant="secondary">

Previous

</Button>


</Link>





<Link

    v-if="saleItemsData.next_page_url"

    :href="saleItemsData.next_page_url"

>


<Button variant="secondary">

Next

</Button>


</Link>



</div>



</div>



</div>


</template>