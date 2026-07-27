<script setup lang="ts">

import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import saleReturns from '@/routes/sale-returns';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';



const page = usePage();



const props = page.props as {

    saleReturns: any;

    filters: {
        search?: string;
    };

};





const form = useForm({

    search: props.filters?.search || '',

});





const saleReturnsData = computed(
    () => props.saleReturns
);







function submitSearch() {

    form.get(

        saleReturns.index.url({

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







function deleteSaleReturn(
    item: { id: number }
) {


    if (
        !confirm(
            'Are you sure you want to delete this sale return?'
        )
    ) {

        return;

    }



    router.delete(

        saleReturns.destroy.url(item.id),

        {

            preserveState: true,

        },

    );


}



</script>


<template>

<Head title="Sale Returns" />



<div class="space-y-6">





<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">



<div>

<h1 class="text-2xl font-semibold">
Sale Returns
</h1>


<p class="text-sm text-muted-foreground">
Manage sale returns.
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






<Link :href="saleReturns.create.url()">



<Button>

New Sale Return

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

Sale

</th>



<th class="px-4 py-3 text-left">

Amount

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

    v-for="saleReturn in saleReturnsData.data"

    :key="saleReturn.id"

>



<td class="px-4 py-4">

{{ saleReturn.reference_no }}

</td>




<td class="px-4 py-4">

{{ saleReturn.customer?.name ?? '-' }}

</td>




<td class="px-4 py-4">

{{ saleReturn.sale?.reference_no ?? '-' }}

</td>




<td class="px-4 py-4">

{{ saleReturn.total_amount }}

</td>




<td class="px-4 py-4">

{{ saleReturn.return_date }}

</td>







<td class="px-4 py-4 text-right">



<Link

    :href="saleReturns.edit.url(saleReturn.id)"

    class="text-primary underline"

>

Edit

</Link>






<button

    type="button"

    class="ml-4 text-red-600 underline"

    @click="deleteSaleReturn(saleReturn)"

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

{{ saleReturnsData.from }}

to

{{ saleReturnsData.to }}

of

{{ saleReturnsData.total }}

sale returns



</div>







<div class="flex gap-2">



<Link

    v-if="saleReturnsData.prev_page_url"

    :href="saleReturnsData.prev_page_url"

>


<Button variant="secondary">

Previous

</Button>


</Link>






<Link

    v-if="saleReturnsData.next_page_url"

    :href="saleReturnsData.next_page_url"

>


<Button variant="secondary">

Next

</Button>


</Link>



</div>



</div>





</div>



</template>