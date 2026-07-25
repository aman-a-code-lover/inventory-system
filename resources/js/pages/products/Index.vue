<script setup lang="ts">
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';


import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import products from '@/routes/products';

const page = usePage();

const props = page.props as {
    products: any;
    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search || '',
});

const productsData = computed(() => props.products);

function submitSearch() {
    form.get(
        products.index.url({
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

function deleteProduct(product: { id: number }) {
    if (!confirm('Are you sure you want to delete this product?')) {
        return;
    }

    router.delete(products.destroy.url(product.id), {
        preserveState: true,
    });
}
</script>

<template>
    <Head title="Products" />

    <div class="space-y-6">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-semibold">
                    Products
                </h1>

                <p class="text-sm text-muted-foreground">
                    Manage inventory products.
                </p>
            </div>

            <Button as-child>
                <Link :href="products.create.url()">
                    New Product
                </Link>
            </Button>

        </div>

        <form
            class="flex gap-2"
            @submit.prevent="submitSearch"
        >
            <Label for="search">
                Search
            </Label>

            <Input
                id="search"
                v-model="form.search"
                placeholder="Search product..."
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

        <div class="overflow-x-auto rounded-lg border">

            <table class="min-w-full">

                <thead class="bg-muted">

                    <tr>

                        <th class="px-4 py-3 text-left">
                            SKU
                        </th>

                        <th class="px-4 py-3 text-left">
                            Name
                        </th>

                        <th class="px-4 py-3 text-left">
                            Category
                        </th>

                        <th class="px-4 py-3 text-left">
                            Brand
                        </th>

                        <th class="px-4 py-3 text-left">
                            Unit
                        </th>

                        <th class="px-4 py-3 text-right">
                            Cost
                        </th>

                        <th class="px-4 py-3 text-right">
                            Selling
                        </th>

                        <th class="px-4 py-3 text-center">
                            Status
                        </th>

                        <th class="px-4 py-3 text-center">
                            Deleted
                        </th>

                        <th class="px-4 py-3 text-right">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr
                        v-for="product in productsData.data"
                        :key="product.id"
                        class="border-t"
                    >

                        <td class="px-4 py-3">
                            {{ product.sku ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ product.name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ product.category?.name ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ product.brand?.name ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ product.unit?.name ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            {{ product.cost_price }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            {{ product.sell_price }}
                        </td>

                        <td class="px-4 py-3 text-center">

                            <span
                                v-if="product.is_active"
                                class="rounded bg-green-100 px-2 py-1 text-xs text-green-700"
                            >
                                Active
                            </span>

                            <span
                                v-else
                                class="rounded bg-red-100 px-2 py-1 text-xs text-red-700"
                            >
                                Inactive
                            </span>

                        </td>

                        <td class="px-4 py-3 text-center">

                            <span
                                v-if="product.deleted_at"
                                class="rounded bg-yellow-100 px-2 py-1 text-xs"
                            >
                                Yes
                            </span>

                            <span
                                v-else
                                class="rounded bg-emerald-100 px-2 py-1 text-xs"
                            >
                                No
                            </span>

                        </td>

                        <td class="px-4 py-3 text-right">

                            <Link
                                v-if="!product.deleted_at"
                                :href="products.edit.url(product.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                class="ml-4 text-red-600 underline"
                                @click="deleteProduct(product)"
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
                {{ productsData.from }}
                to
                {{ productsData.to }}
                of
                {{ productsData.total }}
                products
            </div>

            <div class="flex gap-2">

                <Link
                    v-if="productsData.prev_page_url"
                    :href="productsData.prev_page_url"
                    class="btn btn-secondary"
                >
                    Previous
                </Link>

                <Link
                    v-if="productsData.next_page_url"
                    :href="productsData.next_page_url"
                    class="btn btn-secondary"
                >
                    Next
                </Link>

            </div>

        </div>

    </div>
</template>