<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

defineProps<{
    form: ReturnType<typeof useForm>;
    submit: () => void;
    submitLabel?: string;
    categories: Array<{ id: number; name: string }>;
    brands: Array<{ id: number; name: string }>;
    units: Array<{ id: number; name: string }>;
}>();
</script>

<template>
    <form @submit.prevent="submit" class="space-y-8">

        <!-- General Information -->
        <div class="rounded-lg border p-6">
            <h2 class="mb-6 text-lg font-semibold">
                General Information
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <div class="space-y-2">
                    <Label for="sku">SKU</Label>

                    <Input
                        id="sku"
                        v-model="form.sku"
                        placeholder="SKU"
                    />

                    <InputError :message="form.errors.sku" />
                </div>

                <div class="space-y-2">
                    <Label for="barcode">Barcode</Label>

                    <Input
                        id="barcode"
                        v-model="form.barcode"
                        placeholder="Barcode"
                    />

                    <InputError :message="form.errors.barcode" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <Label for="name">Product Name</Label>

                    <Input
                        id="name"
                        v-model="form.name"
                        placeholder="Product name"
                        required
                    />

                    <InputError :message="form.errors.name" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <Label for="description">Description</Label>

                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="4"
                        class="w-full rounded-md border bg-background px-3 py-2"
                    />

                    <InputError :message="form.errors.description" />
                </div>

            </div>
        </div>

        <!-- Relations -->
        <div class="rounded-lg border p-6">

            <h2 class="mb-6 text-lg font-semibold">
                Product Information
            </h2>

            <div class="grid gap-6 md:grid-cols-3">

                <div class="space-y-2">
                    <Label>Category</Label>

                    <select
                        v-model="form.category_id"
                        class="w-full rounded-md border bg-background px-3 py-2"
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
                    <Label>Brand</Label>

                    <select
                        v-model="form.brand_id"
                        class="w-full rounded-md border bg-background px-3 py-2"
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
                    <Label>Unit</Label>

                    <select
                        v-model="form.unit_id"
                        class="w-full rounded-md border bg-background px-3 py-2"
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
                    <Label>Cost Price</Label>

                    <Input
                        type="number"
                        step="0.01"
                        min="0"
                        v-model="form.cost_price"
                    />

                    <InputError :message="form.errors.cost_price" />
                </div>

                <div class="space-y-2">
                    <Label>Selling Price</Label>

                    <Input
                        type="number"
                        step="0.01"
                        min="0"
                        v-model="form.sell_price"
                    />

                    <InputError :message="form.errors.sell_price" />
                </div>

                <div class="space-y-2">
                    <Label>Reorder Level</Label>

                    <Input
                        type="number"
                        step="0.01"
                        min="0"
                        v-model="form.reorder_level"
                    />

                    <InputError :message="form.errors.reorder_level" />
                </div>

            </div>

        </div>

        <!-- Status -->

        <div class="rounded-lg border p-6">

            <label class="flex items-center gap-3">

                <input
                    type="checkbox"
                    v-model="form.is_active"
                >

                <span>Active Product</span>

            </label>

            <InputError :message="form.errors.is_active" />

        </div>

        <div class="flex justify-end">

            <Button type="submit">
                {{ submitLabel ?? 'Save Product' }}
            </Button>

        </div>

    </form>
</template>