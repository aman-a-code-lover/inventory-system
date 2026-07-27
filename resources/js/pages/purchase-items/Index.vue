<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import purchaseItems from '@/routes/purchase-items';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const page = usePage();

const props = page.props as {
    purchaseItems: any;
    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search || '',
});

const purchaseItemsData = computed(() => props.purchaseItems);

function submitSearch() {
    form.get(
        purchaseItems.index.url({
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

function deletePurchaseItem(item: { id: number }) {
    if (!confirm('Are you sure you want to delete this purchase item?')) {
        return;
    }

    router.delete(
        purchaseItems.destroy.url(item.id),
        {
            preserveState: true,
        },
    );
}
</script>

<template>

<Head title="Purchase Items" />

<div class="space-y-6">

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

<div>

<h1 class="text-2xl font-semibold">
Purchase Items
</h1>

<p class="text-sm text-muted-foreground">
Manage purchase items.
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
    placeholder="Search Product"
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

<Link :href="purchaseItems.create.url()">

<Button>
New Purchase Item
</Button>

</Link>

</div>

</div>

<div class="overflow-hidden rounded-lg border bg-card">

<table class="min-w-full divide-y divide-border">

<thead class="bg-muted">

<tr>

<th class="px-4 py-3 text-left">
Purchase
</th>

<th class="px-4 py-3 text-left">
Product
</th>

<th class="px-4 py-3 text-left">
Qty
</th>

<th class="px-4 py-3 text-left">
Price
</th>

<th class="px-4 py-3 text-left">
Line Total
</th>

<th class="px-4 py-3 text-right">
Actions
</th>

</tr>

</thead>

<tbody class="divide-y divide-border">
                        <tr
                        v-for="item in purchaseItemsData.data"
                        :key="item.id"
                    >

                        <td class="px-4 py-4">
                            {{ item.purchase?.reference_no }}
                        </td>

                        <td class="px-4 py-4">
                            {{ item.product?.name }}
                        </td>

                        <td class="px-4 py-4">
                            {{ item.quantity }}
                        </td>

                        <td class="px-4 py-4">
                            {{ item.unit_price }}
                        </td>

                        <td class="px-4 py-4">
                            {{ item.line_total }}
                        </td>

                        <td class="px-4 py-4 text-right">

                            <Link
                                :href="purchaseItems.edit.url(item.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                type="button"
                                class="ml-4 text-red-600 underline"
                                @click="deletePurchaseItem(item)"
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

                {{ purchaseItemsData.from }}

                to

                {{ purchaseItemsData.to }}

                of

                {{ purchaseItemsData.total }}

                purchase items

            </div>

            <div class="flex gap-2">

                <Link
                    v-if="purchaseItemsData.prev_page_url"
                    :href="purchaseItemsData.prev_page_url"
                >
                    <Button variant="secondary">
                        Previous
                    </Button>
                </Link>

                <Link
                    v-if="purchaseItemsData.next_page_url"
                    :href="purchaseItemsData.next_page_url"
                >
                    <Button variant="secondary">
                        Next
                    </Button>
                </Link>

            </div>

        </div>

    </div>

</template>