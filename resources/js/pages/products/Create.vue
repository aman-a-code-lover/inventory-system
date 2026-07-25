<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import ProductForm from './Partials/Form.vue';
import products from '@/routes/products';

interface Option {
    id: number;
    name: string;
}

const props = defineProps<{
    categories: Option[];
    brands: Option[];
    units: Option[];
}>();

const form = useForm({
    sku: '',
    barcode: '',
    name: '',
    description: '',
    category_id: null as number | null,
    brand_id: null as number | null,
    unit_id: null as number | null,
    cost_price: 0,
    sell_price: 0,
    reorder_level: 0,
    is_active: true,
});

function submit() {
    form.post(products.store.url());
}
</script>

<template>
    <Head title="Create Product" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">
                Create Product
            </h1>

            <p class="text-sm text-muted-foreground">
                Add a new product to your inventory.
            </p>
        </div>

        <ProductForm
            :form="form"
            :submit="submit"
            submit-label="Create Product"
            :categories="categories"
            :brands="brands"
            :units="units"
        />
    </div>
</template>