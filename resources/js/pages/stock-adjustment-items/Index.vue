<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import stockAdjustmentItems from '@/routes/stock-adjustment-items';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const page = usePage();

const props = page.props as {
    stockAdjustmentItems: any;

    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search ?? '',
});

const stockAdjustmentItemsData = computed(
    () => props.stockAdjustmentItems,
);

function submitSearch() {
    form.get(
        stockAdjustmentItems.index.url({
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

function deleteItem(item: { id: number }) {
    if (
        !confirm(
            'Are you sure you want to delete this item?',
        )
    ) {
        return;
    }

    router.delete(
        stockAdjustmentItems.destroy.url(item.id),
    );
}
</script>

<template>

<Head title="Stock Adjustment Items" />

<div class="space-y-6">

<div class="flex items-center justify-between">

<div>

<h1 class="text-2xl font-semibold">
Stock Adjustment Items
</h1>

<p class="text-sm text-muted-foreground">
Manage stock adjustment items.
</p>

</div>

<Link
    :href="stockAdjustmentItems.create.url()"
>

<Button>
New Item
</Button>

</Link>

</div>

<form
    class="flex items-center gap-2"
    @submit.prevent="submitSearch"
>

<Label>
Search
</Label>

<Input
    v-model="form.search"
    placeholder="Product / SKU"
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

<div class="overflow-hidden rounded-lg border bg-card">

<table class="min-w-full divide-y divide-border">

<thead class="bg-muted">

<tr>

<th class="px-4 py-3 text-left">
Adjustment
</th>

<th class="px-4 py-3 text-left">
Product
</th>

<th class="px-4 py-3 text-right">
Before
</th>

<th class="px-4 py-3 text-right">
After
</th>

<th class="px-4 py-3 text-right">
Adjusted
</th>

<th class="px-4 py-3 text-right">
Actions
</th>

</tr>

</thead>

<tbody class="divide-y divide-border">
                        <tr
                        v-for="item in stockAdjustmentItemsData.data"
                        :key="item.id"
                    >
                        <td class="px-4 py-4">
                            {{ item.stock_adjustment?.reference_no }}
                        </td>

                        <td class="px-4 py-4">
                            <div class="font-medium">
                                {{ item.product?.name }}
                            </div>

                            <div class="text-xs text-muted-foreground">
                                {{ item.product?.sku }}
                            </div>
                        </td>

                        <td class="px-4 py-4 text-right">
                            {{ item.quantity_before }}
                        </td>

                        <td class="px-4 py-4 text-right">
                            {{ item.quantity_after }}
                        </td>

                        <td
                            class="px-4 py-4 text-right font-semibold"
                            :class="Number(item.adjustment_quantity) >= 0
                                ? 'text-green-600'
                                : 'text-red-600'"
                        >
                            {{ Number(item.adjustment_quantity) > 0 ? '+' : '' }}
                            {{ item.adjustment_quantity }}
                        </td>

                        <td class="px-4 py-4 text-right">

                            <Link
                                :href="stockAdjustmentItems.edit.url(item.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                type="button"
                                class="ml-4 text-red-600 underline"
                                @click="deleteItem(item)"
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

                {{ stockAdjustmentItemsData.from }}

                to

                {{ stockAdjustmentItemsData.to }}

                of

                {{ stockAdjustmentItemsData.total }}

                items

            </div>

            <div class="flex gap-2">

                <Link
                    v-if="stockAdjustmentItemsData.prev_page_url"
                    :href="stockAdjustmentItemsData.prev_page_url"
                >
                    <Button variant="secondary">
                        Previous
                    </Button>
                </Link>

                <Link
                    v-if="stockAdjustmentItemsData.next_page_url"
                    :href="stockAdjustmentItemsData.next_page_url"
                >
                    <Button variant="secondary">
                        Next
                    </Button>
                </Link>

            </div>

        </div>

    </div>

</template>