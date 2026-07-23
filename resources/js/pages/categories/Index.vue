<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import categories from '@/routes/categories';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Table } from '@/components/ui/table';

const page = usePage();
const props = page.props as { categories: any; filters: { search?: string } };

const form = useForm({
    search: props.filters.search || '',
});

const categoriesData = computed(() => props.categories);

function submitSearch() {
    form.get(categories.index.url({ query: { search: form.search } }), {
        preserveState: true,
        replace: true,
    });
}

function resetSearch() {
    form.search = '';
    submitSearch();
}

function deleteCategory(category: { id: number }) {
    if (!confirm('Are you sure you want to delete this category?')) {
        return;
    }

    router.delete(categories.destroy.url(category.id), {
        preserveState: true,
    });
}
</script>

<template>
    <Head title="Categories" />

    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Categories</h1>
                <p class="text-sm text-muted-foreground">Manage your product categories and soft delete records.</p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <form @submit.prevent="submitSearch" class="flex items-center gap-2">
                    <Label for="search">Search</Label>
                    <Input
                        id="search"
                        name="search"
                        v-model="form.search"
                        placeholder="Search by name"
                        class="min-w-[220px]"
                    />
                    <Button type="submit">Search</Button>
                    <Button type="button" variant="secondary" @click="resetSearch">Reset</Button>
                </form>
                <Link :href="categories.create.url()" class="btn btn-primary">New Category</Link>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border bg-card">
            <table class="min-w-full divide-y divide-border">
                <thead class="bg-muted">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-foreground">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-foreground">Slug</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-foreground">Parent</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-foreground">Deleted</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-background">
                    <tr v-for="category in categoriesData.data" :key="category.id">
                        <td class="px-4 py-4 text-sm">{{ category.name }}</td>
                        <td class="px-4 py-4 text-sm text-muted-foreground">{{ category.slug }}</td>
                        <td class="px-4 py-4 text-sm text-muted-foreground">{{ category.parent?.name || '-' }}</td>
                        <td class="px-4 py-4 text-sm">
                            <span v-if="category.deleted_at" class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">Yes</span>
                            <span v-else class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-800">No</span>
                        </td>
                        <td class="px-4 py-4 text-right text-sm">
                            <Link v-if="category.deleted_at == null"
                                :href="categories.edit.url(category)"
                                class="text-primary underline"
                            >Edit</Link>
                            <button
                                type="button"
                                class="ml-4 text-red-600 underline"
                                @click="deleteCategory(category)"
                            >Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div class="text-sm text-muted-foreground">
                Showing {{ categoriesData.from }} to {{ categoriesData.to }} of {{ categoriesData.total }} categories
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <Link
                    v-if="categoriesData.prev_page_url"
                    :href="categoriesData.prev_page_url"
                    class="btn btn-secondary"
                >Previous</Link>
                <Link
                    v-if="categoriesData.next_page_url"
                    :href="categoriesData.next_page_url"
                    class="btn btn-secondary"
                >Next</Link>
            </div>
        </div>
    </div>
</template>
