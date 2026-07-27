<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import stockAdjustments from '@/routes/stock-adjustments';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const page = usePage();

const props = page.props as {
    stockAdjustments: any;
    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search ?? '',
});

const stockAdjustmentsData = computed(
    () => props.stockAdjustments,
);

function submitSearch() {
    form.get(
        stockAdjustments.index.url({
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

function deleteStockAdjustment(
    stockAdjustment: { id: number },
) {
    if (
        !confirm(
            'Are you sure you want to delete this stock adjustment?',
        )
    ) {
        return;
    }

    router.delete(
        stockAdjustments.destroy.url(
            stockAdjustment.id,
        ),
    );
}
</script>

<template>

<Head title="Stock Adjustments" />

<div class="space-y-6">

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

<div>

<h1 class="text-2xl font-semibold">
Stock Adjustments
</h1>

<p class="text-sm text-muted-foreground">
Manage stock adjustments.
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
    placeholder="Reference"
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
    :href="stockAdjustments.create.url()"
>

<Button>
New Adjustment
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
Warehouse
</th>

<th class="px-4 py-3 text-left">
Status
</th>

<th class="px-4 py-3 text-right">
Total
</th>

<th class="px-4 py-3 text-left">
Created By
</th>

<th class="px-4 py-3 text-right">
Actions
</th>

</tr>

</thead>

<tbody class="divide-y divide-border">
                        <tr
                        v-for="stockAdjustment in stockAdjustmentsData.data"
                        :key="stockAdjustment.id"
                    >

                        <td class="px-4 py-4">
                            {{ stockAdjustment.reference_no }}
                        </td>

                        <td class="px-4 py-4">
                            {{ stockAdjustment.warehouse?.name ?? '-' }}
                        </td>

                        <td class="px-4 py-4">

                            <span
                                class="rounded-full px-2 py-1 text-xs font-medium"
                                :class="{
                                    'bg-yellow-100 text-yellow-700': stockAdjustment.status === 'pending',
                                    'bg-green-100 text-green-700': stockAdjustment.status === 'posted',
                                    'bg-red-100 text-red-700': stockAdjustment.status === 'cancelled',
                                }"
                            >
                                {{ stockAdjustment.status }}
                            </span>

                        </td>

                        <td class="px-4 py-4 text-right">
                            {{ stockAdjustment.total_adjusted }}
                        </td>

                        <td class="px-4 py-4">
                            {{ stockAdjustment.creator?.name ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-right">

                            <Link
                                :href="stockAdjustments.edit.url(stockAdjustment.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                type="button"
                                class="ml-4 text-red-600 underline"
                                @click="deleteStockAdjustment(stockAdjustment)"
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

                {{ stockAdjustmentsData.from }}

                to

                {{ stockAdjustmentsData.to }}

                of

                {{ stockAdjustmentsData.total }}

                stock adjustments

            </div>

            <div class="flex gap-2">

                <Link
                    v-if="stockAdjustmentsData.prev_page_url"
                    :href="stockAdjustmentsData.prev_page_url"
                >
                    <Button variant="secondary">
                        Previous
                    </Button>
                </Link>

                <Link
                    v-if="stockAdjustmentsData.next_page_url"
                    :href="stockAdjustmentsData.next_page_url"
                >
                    <Button variant="secondary">
                        Next
                    </Button>
                </Link>

            </div>

        </div>

    </div>

</template>