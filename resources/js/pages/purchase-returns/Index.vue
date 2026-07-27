<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import purchaseReturns from '@/routes/purchase-returns';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const page = usePage();

const props = page.props as {
    purchaseReturns: any;
    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search || '',
});

const purchaseReturnsData = computed(() => props.purchaseReturns);

function submitSearch() {
    form.get(
        purchaseReturns.index.url({
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

function deletePurchaseReturn(item: { id: number }) {
    if (!confirm('Are you sure you want to delete this purchase return?')) {
        return;
    }

    router.delete(
        purchaseReturns.destroy.url(item.id),
        {
            preserveState: true,
        },
    );
}
</script>

<template>

<Head title="Purchase Returns" />

<div class="space-y-6">

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

<div>

<h1 class="text-2xl font-semibold">
Purchase Returns
</h1>

<p class="text-sm text-muted-foreground">
Manage purchase returns.
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
    placeholder="Reference No"
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

<Link :href="purchaseReturns.create.url()">

<Button>
New Purchase Return
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
Purchase
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
                        v-for="purchaseReturn in purchaseReturnsData.data"
                        :key="purchaseReturn.id"
                    >

                        <td class="px-4 py-4">
                            {{ purchaseReturn.reference_no }}
                        </td>

                        <td class="px-4 py-4">
                            {{ purchaseReturn.supplier?.name ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ purchaseReturn.purchase?.reference_no ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ purchaseReturn.total_amount }}
                        </td>

                        <td class="px-4 py-4">
                            {{ purchaseReturn.return_date }}
                        </td>

                        <td class="px-4 py-4 text-right">

                            <Link
                                :href="purchaseReturns.edit.url(purchaseReturn.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                type="button"
                                class="ml-4 text-red-600 underline"
                                @click="deletePurchaseReturn(purchaseReturn)"
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

                {{ purchaseReturnsData.from }}

                to

                {{ purchaseReturnsData.to }}

                of

                {{ purchaseReturnsData.total }}

                purchase returns

            </div>

            <div class="flex gap-2">

                <Link
                    v-if="purchaseReturnsData.prev_page_url"
                    :href="purchaseReturnsData.prev_page_url"
                >
                    <Button variant="secondary">
                        Previous
                    </Button>
                </Link>

                <Link
                    v-if="purchaseReturnsData.next_page_url"
                    :href="purchaseReturnsData.next_page_url"
                >
                    <Button variant="secondary">
                        Next
                    </Button>
                </Link>

            </div>

        </div>

    </div>

</template>