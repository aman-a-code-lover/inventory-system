<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import purchases from '@/routes/purchases';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const page = usePage();

const props = page.props as {
    purchases: any;
    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search || '',
});

const purchasesData = computed(() => props.purchases);

function submitSearch() {
    form.get(
        purchases.index.url({
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

function deletePurchase(purchase: { id: number }) {
    if (!confirm('Are you sure you want to delete this purchase?')) {
        return;
    }

    router.delete(purchases.destroy.url(purchase.id), {
        preserveState: true,
    });
}
</script>

<template>

<Head title="Purchases" />

<div class="space-y-6">

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

<div>

<h1 class="text-2xl font-semibold">
Purchases
</h1>

<p class="text-sm text-muted-foreground">
Manage purchases.
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
    placeholder="Reference or Supplier"
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

<Link :href="purchases.create.url()">

<Button>
New Purchase
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
Supplier
</th>

<th class="px-4 py-3 text-left">
Warehouse
</th>

<th class="px-4 py-3 text-left">
Status
</th>

<th class="px-4 py-3 text-left">
Purchase Date
</th>

<th class="px-4 py-3 text-right">
Actions
</th>

</tr>

</thead>

<tbody class="divide-y divide-border">
                        <tr
                        v-for="purchase in purchasesData.data"
                        :key="purchase.id"
                    >

                        <td class="px-4 py-4">
                            {{ purchase.reference_no }}
                        </td>

                        <td class="px-4 py-4">
                            {{ purchase.supplier?.name ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ purchase.warehouse?.name ?? '-' }}
                        </td>

                        <td class="px-4 py-4">

                            <span
                                class="rounded-full px-2 py-1 text-xs font-medium"
                                :class="{
                                    'bg-gray-100 text-gray-700': purchase.status === 'draft',
                                    'bg-yellow-100 text-yellow-800': purchase.status === 'pending',
                                    'bg-green-100 text-green-700': purchase.status === 'received',
                                    'bg-red-100 text-red-700': purchase.status === 'cancelled',
                                }"
                            >
                                {{ purchase.status }}
                            </span>

                        </td>

                        <td class="px-4 py-4">
                            {{ purchase.purchase_date }}
                        </td>

                        <td class="px-4 py-4 text-right">

                            <Link
                                :href="purchases.edit.url(purchase.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                type="button"
                                class="ml-4 text-red-600 underline"
                                @click="deletePurchase(purchase)"
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

                {{ purchasesData.from }}

                to

                {{ purchasesData.to }}

                of

                {{ purchasesData.total }}

                purchases

            </div>

            <div class="flex gap-2">

                <Link
                    v-if="purchasesData.prev_page_url"
                    :href="purchasesData.prev_page_url"
                >
                    <Button variant="secondary">
                        Previous
                    </Button>
                </Link>

                <Link
                    v-if="purchasesData.next_page_url"
                    :href="purchasesData.next_page_url"
                >
                    <Button variant="secondary">
                        Next
                    </Button>
                </Link>

            </div>

        </div>

    </div>

</template>