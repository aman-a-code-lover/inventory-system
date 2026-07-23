<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import BrandForm from './Partials/Form.vue';
import brands from '@/routes/brands';

interface Brand {
    id: number;
    name: string;
    slug: string | null;
    description: string | null;
}

const props = defineProps<{
    brand: Brand;
}>();

const form = useForm({
    name: props.brand.name,
    slug: props.brand.slug ?? '',
    description: props.brand.description ?? '',
});

function submit() {
    form.put(brands.update.url(props.brand.id));
}
</script>

<template>
    <Head title="Edit Brand" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">Edit Brand</h1>
            <p class="text-sm text-muted-foreground">
                Update brand information.
            </p>
        </div>

        <BrandForm
            :form="form"
            :submit="submit"
            submit-label="Update Brand"
        />
    </div>
</template>