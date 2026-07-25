<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import ProductForm from './Partials/Form.vue';
import products from '@/routes/products';

interface Option {
    id: number;
    name: string;
}

interface Product {
    id: number;
    sku: string | null;
    barcode: string | null;
    name: string;
    description: string | null;
    category_id: number | null;
    brand_id: number | null;
    unit_id: number | null;
    cost_price: number;
    sell_price: number;
    reorder_level: number;
    is_active: boolean;
}

const props = defineProps<{
    product: Product;
    categories: Option[];
    brands: Option[];
    units: Option[];
}>();

const form = useForm({
    sku: props.product.sku ?? '',
    barcode: props.product.barcode ?? '',
    name: props.product.name,
    description: props.product.description ?? '',
    category_id: props.product.category_id,
    brand_id: props.product.brand_id,
    unit_id: props.product.unit_id,
    cost_price: props.product.cost_price,
    sell_price: props.product.sell_price,
    reorder_level: props.product.reorder_level,
    is_active: props.product.is_active,
});

function submit() {
    form.put(products.update.url(props.product.id));
}
</script>

<template>
    <Head title="Edit Product" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">
                Edit Product
            </h1>

            <p class="text-sm text-muted-foreground">
                Update product information.
            </p>
        </div>

        <ProductForm
            :form="form"
            :submit="submit"
            submit-label="Update Product"
            :categories="categories"
            :brands="brands"
            :units="units"
        />
    </div>
</template>