<script setup lang="ts">

import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import customers from '@/routes/customers';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';


const page = usePage();


const props = page.props as {
    customers: any;

    filters: {
        search?: string;
    };
};


const form = useForm({
    search: props.filters.search || '',
});


const customersData = computed(
    () => props.customers
);



function submitSearch() {

    form.get(
        customers.index.url({
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



function deleteCustomer(
    customer: { id: number }
) {

    if (
        !confirm(
            'Are you sure you want to delete this customer?'
        )
    ) {
        return;
    }


    router.delete(
        customers.destroy.url(customer.id),
        {
            preserveState: true,
        },
    );

}

</script>


<template>

<Head title="Customers" />


<div class="space-y-6">


<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">


<div>

<h1 class="text-2xl font-semibold">
Customers
</h1>


<p class="text-sm text-muted-foreground">
Manage customers.
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
    placeholder="Name / Email / Phone"
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



<Link
    :href="customers.create.url()"
>

<Button>
New Customer
</Button>

</Link>


</div>


</div>





<div class="overflow-hidden rounded-lg border bg-card">


<table class="min-w-full divide-y divide-border">


<thead class="bg-muted">


<tr>


<th class="px-4 py-3 text-left">
Name
</th>


<th class="px-4 py-3 text-left">
Code
</th>


<th class="px-4 py-3 text-left">
Email
</th>


<th class="px-4 py-3 text-left">
Phone
</th>


<th class="px-4 py-3 text-left">
Contact Person
</th>


<th class="px-4 py-3 text-right">
Actions
</th>


</tr>


</thead>



<tbody class="divide-y divide-border">


<tr
    v-for="customer in customersData.data"
    :key="customer.id"
>


<td class="px-4 py-4">
{{ customer.name }}
</td>


<td class="px-4 py-4">
{{ customer.code ?? '-' }}
</td>


<td class="px-4 py-4">
{{ customer.email ?? '-' }}
</td>


<td class="px-4 py-4">
{{ customer.phone ?? '-' }}
</td>


<td class="px-4 py-4">
{{ customer.contact_person ?? '-' }}
</td>



<td class="px-4 py-4 text-right">


<Link
    :href="customers.edit.url(customer.id)"
    class="text-primary underline"
>
Edit
</Link>



<button
    type="button"
    class="ml-4 text-red-600 underline"
    @click="deleteCustomer(customer)"
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

{{ customersData.from }}

to

{{ customersData.to }}

of

{{ customersData.total }}

customers


</div>



<div class="flex gap-2">


<Link
    v-if="customersData.prev_page_url"
    :href="customersData.prev_page_url"
>

<Button variant="secondary">
Previous
</Button>

</Link>



<Link
    v-if="customersData.next_page_url"
    :href="customersData.next_page_url"
>

<Button variant="secondary">
Next
</Button>

</Link>


</div>


</div>



</div>


</template>