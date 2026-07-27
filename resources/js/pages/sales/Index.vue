<script setup lang="ts">

import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import sales from '@/routes/sales';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';


const page = usePage();


const props = page.props as {
    sales: any;

    filters: {
        search?: string;
    };
};


const form = useForm({
    search: props.filters?.search || '',
});


const salesData = computed(
    () => props.sales
);



function submitSearch() {

    form.get(
        sales.index.url({
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



function deleteSale(
    sale: { id: number }
) {

    if (
        !confirm(
            'Are you sure you want to delete this sale?'
        )
    ) {
        return;
    }


    router.delete(
        sales.destroy.url(sale.id),
        {
            preserveState: true,
        },
    );

}

</script>


<template>

<Head title="Sales" />


<div class="space-y-6">


<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">


<div>

<h1 class="text-2xl font-semibold">
Sales
</h1>


<p class="text-sm text-muted-foreground">
Manage sales.
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
    placeholder="Reference / Customer"
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



<Link :href="sales.create.url()">

<Button>
New Sale
</Button>

</Link>


</div>


</div>





<div class="overflow-hidden rounded-lg border bg-card">


<table class="min-w-full divide-y divide-border">


<thead class="bg-muted">


<tr>

<th class="px-4 py-3 text-left">
Reference
</th>


<th class="px-4 py-3 text-left">
Customer
</th>


<th class="px-4 py-3 text-left">
Amount
</th>


<th class="px-4 py-3 text-left">
Status
</th>


<th class="px-4 py-3 text-left">
Date
</th>


<th class="px-4 py-3 text-right">
Actions
</th>


</tr>


</thead>




<tbody class="divide-y divide-border">


<tr
    v-for="sale in salesData.data"
    :key="sale.id"
>


<td class="px-4 py-4">
{{ sale.reference_no }}
</td>


<td class="px-4 py-4">
{{ sale.customer?.name ?? '-' }}
</td>


<td class="px-4 py-4">
{{ sale.total_amount }}
</td>


<td class="px-4 py-4">
{{ sale.status }}
</td>


<td class="px-4 py-4">
{{ sale.sale_date }}
</td>



<td class="px-4 py-4 text-right">


<Link
    :href="sales.edit.url(sale.id)"
    class="text-primary underline"
>
Edit
</Link>



<button
    type="button"
    class="ml-4 text-red-600 underline"
    @click="deleteSale(sale)"
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

{{ salesData.from }}

to

{{ salesData.to }}

of

{{ salesData.total }}

sales


</div>




<div class="flex gap-2">


<Link
    v-if="salesData.prev_page_url"
    :href="salesData.prev_page_url"
>

<Button variant="secondary">
Previous
</Button>

</Link>




<Link
    v-if="salesData.next_page_url"
    :href="salesData.next_page_url"
>

<Button variant="secondary">
Next
</Button>

</Link>


</div>


</div>



</div>


</template>