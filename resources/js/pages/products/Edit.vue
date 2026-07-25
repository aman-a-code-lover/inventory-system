<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

import products from '@/routes/products';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

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

    <div class="space-y-8">

        <div>
            <h1 class="text-2xl font-semibold">
                Edit Product
            </h1>

            <p class="text-sm text-muted-foreground">
                Update product information.
            </p>
        </div>

        <form
            class="space-y-8"
            @submit.prevent="submit"
        >

            <!-- General Information -->

            <div class="rounded-lg border p-6">

                <h2 class="mb-6 text-lg font-semibold">
                    General Information
                </h2>

                <div class="grid gap-6 md:grid-cols-2">

                    <div class="space-y-2">

                        <Label for="sku">
                            SKU
                        </Label>

                        <Input
                            id="sku"
                            v-model="form.sku"
                            placeholder="SKU"
                        />

                        <InputError :message="form.errors.sku" />

                    </div>

                    <div class="space-y-2">

                        <Label for="barcode">
                            Barcode
                        </Label>

                        <Input
                            id="barcode"
                            v-model="form.barcode"
                            placeholder="Barcode"
                        />

                        <InputError :message="form.errors.barcode" />

                    </div>

                    <div class="space-y-2 md:col-span-2">

                        <Label for="name">
                            Product Name
                        </Label>

                        <Input
                            id="name"
                            v-model="form.name"
                            placeholder="Product name"
                            required
                        />

                        <InputError :message="form.errors.name" />

                    </div>

                    <div class="space-y-2 md:col-span-2">

                        <Label for="description">
                            Description
                        </Label>

                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            class="w-full rounded-md border border-input bg-background px-3 py-2"
                        />

                        <InputError :message="form.errors.description" />

                    </div>

                </div>

            </div>

            <!-- Product Information -->

            <div class="rounded-lg border p-6">

                <h2 class="mb-6 text-lg font-semibold">
                    Product Information
                </h2>

                <div class="grid gap-6 md:grid-cols-3">

                    <div class="space-y-2">

                        <Label for="category_id">
                            Category
                        </Label>

                        <select
                            id="category_id"
                            v-model="form.category_id"
                            class="w-full rounded-md border border-input bg-background px-3 py-2"
                        >
                            <option :value="null">
                                Select Category
                            </option>

                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>

                        </select>

                        <InputError :message="form.errors.category_id" />

                    </div>

                    <div class="space-y-2">

                        <Label for="brand_id">
                            Brand
                        </Label>

                        <select
                            id="brand_id"
                            v-model="form.brand_id"
                            class="w-full rounded-md border border-input bg-background px-3 py-2"
                        >
                            <option :value="null">
                                Select Brand
                            </option>

                            <option
                                v-for="brand in brands"
                                :key="brand.id"
                                :value="brand.id"
                            >
                                {{ brand.name }}
                            </option>

                        </select>

                        <InputError :message="form.errors.brand_id" />

                    </div>

                    <div class="space-y-2">

                        <Label for="unit_id">
                            Unit
                        </Label>

                        <select
                            id="unit_id"
                            v-model="form.unit_id"
                            class="w-full rounded-md border border-input bg-background px-3 py-2"
                        >
                            <option :value="null">
                                Select Unit
                            </option>

                            <option
                                v-for="unit in units"
                                :key="unit.id"
                                :value="unit.id"
                            >
                                {{ unit.name }}
                            </option>

                        </select>

                        <InputError :message="form.errors.unit_id" />

                    </div>

                </div>

            </div>
                        <!-- Pricing -->

            <div class="rounded-lg border p-6">

                <h2 class="mb-6 text-lg font-semibold">
                    Pricing
                </h2>

                <div class="grid gap-6 md:grid-cols-3">

                    <div class="space-y-2">

                        <Label for="cost_price">
                            Cost Price
                        </Label>

                        <Input
                            id="cost_price"
                            type="number"
                            min="0"
                            step="0.01"
                            v-model="form.cost_price"
                        />

                        <InputError :message="form.errors.cost_price" />

                    </div>

                    <div class="space-y-2">

                        <Label for="sell_price">
                            Selling Price
                        </Label>

                        <Input
                            id="sell_price"
                            type="number"
                            min="0"
                            step="0.01"
                            v-model="form.sell_price"
                        />

                        <InputError :message="form.errors.sell_price" />

                    </div>

                    <div class="space-y-2">

                        <Label for="reorder_level">
                            Reorder Level
                        </Label>

                        <Input
                            id="reorder_level"
                            type="number"
                            min="0"
                            step="0.01"
                            v-model="form.reorder_level"
                        />

                        <InputError :message="form.errors.reorder_level" />

                    </div>

                </div>

            </div>

            <!-- Status -->

            <div class="rounded-lg border p-6">

                <div class="flex items-center gap-3">

                    <input
                        id="is_active"
                        type="checkbox"
                        v-model="form.is_active"
                        class="h-4 w-4 rounded border-gray-300"
                    >

                    <Label
                        for="is_active"
                        class="cursor-pointer"
                    >
                        Active Product
                    </Label>

                </div>

                <InputError
                    class="mt-2"
                    :message="form.errors.is_active"
                />

            </div>

            <!-- Action Buttons -->

            <div class="flex items-center justify-end gap-3">

                <Button
                    variant="outline"
                    as-child
                >
                    <Link :href="products.index.url()">
                        Cancel
                    </Link>
                </Button>

                <Button
                    type="submit"
                    :disabled="form.processing"
                >
                    Update Product
                </Button>

            </div>

        </form>

    </div>

</template>