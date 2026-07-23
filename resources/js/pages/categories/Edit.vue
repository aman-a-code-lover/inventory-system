<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, watch } from 'vue';
import categories from '@/routes/categories';
import CategoryForm from '@/components/categories/Form.vue';

const page = usePage();

const categoryData = computed(() => page.props.category as any);

const form = useForm({
    name: '',
    slug: '',
    description: '',
    parent_id: '',
});

// Update form when category data is available
watch(() => categoryData.value, (cat) => {
    if (cat) {
        form.name = cat.name;
        form.slug = cat.slug;
        form.description = cat.description;
        form.parent_id = cat.parent_id || '';
    }
}, { immediate: true });

const parentOptions = computed(() => page.props.parentCategories ?? []);
</script>

<template>
    <Head title="Edit Category" />

    <CategoryForm
        v-if="categoryData?.id"
        :form="form"
        :action="categories.update.url(categoryData.id)"
        method="put"
        title="Edit category"
        description="Update the category details."
        submit-label="Save changes"
        :back-url="categories.index.url()"
        :parents="parentOptions"
    />
</template>
