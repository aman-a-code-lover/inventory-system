<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import stockMovements from '@/routes/stock-movements';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const page = usePage();

const props = page.props as {
    stockMovements: any;

    warehouses: Array<{
        id: number;
        name: string;
    }>;

    movementTypes: string[];

    filters: {
        search?: string;
        warehouse_id?: number | null;
        movement_type?: string;
        from_date?: string;
        to_date?: string;
    };
};

const form = useForm({
    search: props.filters.search ?? '',

    warehouse_id: props.filters.warehouse_id ?? '',

    movement_type: props.filters.movement_type ?? '',

    from_date: props.filters.from_date ?? '',

    to_date: props.filters.to_date ?? '',
});

const stockMovementsData = computed(() => props.stockMovements);

function submitSearch() {
    form.get(
        stockMovements.index.url({
            query: {
                search: form.search,
                warehouse_id: form.warehouse_id,
                movement_type: form.movement_type,
                from_date: form.from_date,
                to_date: form.to_date,
            },
        }),
        {
            preserveState: true,
            replace: true,
        },
    );
}

function resetFilters() {
    form.search = '';
    form.warehouse_id = '';
    form.movement_type = '';
    form.from_date = '';
    form.to_date = '';

    submitSearch();
}

function quantityClass(quantity: number | string) {
    return Number(quantity) >= 0
        ? 'text-green-600 font-semibold'
        : 'text-red-600 font-semibold';
}
</script>

<template>

<Head title="Stock Movements" />

<div class="space-y-6">

<div class="flex items-center justify-between">

<div>

<h1 class="text-2xl font-semibold">
Stock Movements
</h1>

<p class="text-sm text-muted-foreground">
Complete stock movement history.
</p>

</div>

</div>

<form
    class="grid gap-4 rounded-lg border p-4 md:grid-cols-6"
    @submit.prevent="submitSearch"
>

<div>

<Label>
Search
</Label>

<Input
    v-model="form.search"
    placeholder="Product / SKU"
/>

</div>

<div>

<Label>
Warehouse
</Label>

<select
    v-model="form.warehouse_id"
    class="w-full rounded-md border px-3 py-2"
>

<option value="">
All
</option>

<option
    v-for="warehouse in warehouses"
    :key="warehouse.id"
    :value="warehouse.id"
>
{{ warehouse.name }}
</option>

</select>

</div>

<div>

<Label>
Movement
</Label>

<select
    v-model="form.movement_type"
    class="w-full rounded-md border px-3 py-2"
>

<option value="">
All
</option>

<option
    v-for="type in movementTypes"
    :key="type"
    :value="type"
>
{{ type }}
</option>

</select>

</div>
<div>

    <Label>
        From Date
    </Label>

    <Input
        type="date"
        v-model="form.from_date"
    />

</div>

<div>

    <Label>
        To Date
    </Label>

    <Input
        type="date"
        v-model="form.to_date"
    />

</div>

<div class="flex items-end gap-2">

    <Button type="submit">
        Search
    </Button>

    <Button
        type="button"
        variant="secondary"
        @click="resetFilters"
    >
        Reset
    </Button>

</div>

</form>

<div class="overflow-hidden rounded-lg border bg-card">

<table class="min-w-full divide-y divide-border">

<thead class="bg-muted">

<tr>

<th class="px-4 py-3 text-left">
Date
</th>

<th class="px-4 py-3 text-left">
Product
</th>

<th class="px-4 py-3 text-left">
Warehouse
</th>

<th class="px-4 py-3 text-left">
Movement
</th>

<th class="px-4 py-3 text-right">
Quantity
</th>

<th class="px-4 py-3 text-right">
Balance
</th>

<th class="px-4 py-3 text-left">
User
</th>

</tr>

</thead>

<tbody class="divide-y divide-border">

<tr
    v-for="movement in stockMovementsData.data"
    :key="movement.id"
>

<td class="px-4 py-4">

{{ movement.created_at }}

</td>

<td class="px-4 py-4">

<div class="font-medium">
{{ movement.product?.name }}
</div>

<div class="text-xs text-muted-foreground">
{{ movement.product?.sku }}
</div>

</td>

<td class="px-4 py-4">

{{ movement.warehouse?.name ?? '-' }}

</td>

<td class="px-4 py-4">

<span
    class="rounded-full px-2 py-1 text-xs font-medium"
    :class="{
        'bg-green-100 text-green-700': movement.movement_type === 'purchase',
        'bg-red-100 text-red-700': movement.movement_type === 'sale',
        'bg-orange-100 text-orange-700': movement.movement_type === 'purchase_return',
        'bg-blue-100 text-blue-700': movement.movement_type === 'sale_return',
        'bg-purple-100 text-purple-700': movement.movement_type === 'adjustment',
        'bg-cyan-100 text-cyan-700': movement.movement_type === 'transfer_in',
        'bg-indigo-100 text-indigo-700': movement.movement_type === 'transfer_out',
        'bg-gray-100 text-gray-700': movement.movement_type === 'manual',
    }"
>

{{ movement.movement_type }}

</span>

</td>
                        <td
                            class="px-4 py-4 text-right"
                            :class="quantityClass(movement.quantity)"
                        >
                            {{ Number(movement.quantity) > 0 ? '+' : '' }}
                            {{ movement.quantity }}
                        </td>

                        <td class="px-4 py-4 text-right">

                            {{ movement.balance_after ?? '-' }}

                        </td>

                        <td class="px-4 py-4">

                            {{ movement.creator?.name ?? '-' }}

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        <div class="flex items-center justify-between">

            <div class="text-sm text-muted-foreground">

                Showing

                {{ stockMovementsData.from }}

                to

                {{ stockMovementsData.to }}

                of

                {{ stockMovementsData.total }}

                stock movements

            </div>

            <div class="flex gap-2">

                <Link
                    v-if="stockMovementsData.prev_page_url"
                    :href="stockMovementsData.prev_page_url"
                >
                    <Button variant="secondary">
                        Previous
                    </Button>
                </Link>

                <Link
                    v-if="stockMovementsData.next_page_url"
                    :href="stockMovementsData.next_page_url"
                >
                    <Button variant="secondary">
                        Next
                    </Button>
                </Link>

            </div>

        </div>

    </div>

</template>