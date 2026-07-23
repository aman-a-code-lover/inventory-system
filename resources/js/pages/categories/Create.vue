<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import categories from '@/routes/categories';
import CategoryForm from '@/components/categories/Form.vue';

const page = usePage();
const form = useForm({
    name: '',
    slug: '',
    description: '',
    parent_id: '',
});

const parentOptions = computed(() => page.props.parentCategories ?? []);
</script>

<template>
    <Head title="Create Category" />

    <CategoryForm
        :form="form"
        :action="categories.store.url()"
        method="post"
        title="Create category"
        description="Add a new category for your inventory."
        submit-label="Create"
        :back-url="categories.index.url()"
        :parents="parentOptions"
    />
</template>
