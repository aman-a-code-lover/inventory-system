<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import BrandForm from './Partials/Form.vue';
import brands from '@/routes/brands';

const form = useForm({
    name: '',
    slug: '',
    description: '',
});

function submit() {
    form.post(brands.store.url());
}
</script>

<template>
    <Head title="Create Brand" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">Create Brand</h1>
            <p class="text-sm text-muted-foreground">
                Add a new product brand.
            </p>
        </div>

        <BrandForm
            :form="form"
            :submit="submit"
            submit-label="Create Brand"
        />
    </div>
</template>