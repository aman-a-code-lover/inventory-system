<script setup lang="ts">
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import brands from '@/routes/brands';

const page = usePage();

const props = page.props as {
    brands: any;
    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search || '',
});

const brandsData = computed(() => props.brands);

function submitSearch() {
    form.get(
        brands.index.url({
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

function deleteBrand(brand: { id: number }) {
    if (!confirm('Are you sure you want to delete this brand?')) {
        return;
    }

    router.delete(brands.destroy.url(brand.id), {
        preserveState: true,
    });
}
</script>

<template>
    <Head title="Brands" />

    <div class="space-y-6">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="text-2xl font-semibold">Brands</h1>
                <p class="text-sm text-muted-foreground">
                    Manage your product brands.
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">

                <form
                    class="flex items-center gap-2"
                    @submit.prevent="submitSearch"
                >
                    <Label for="search">Search</Label>

                    <Input
                        id="search"
                        v-model="form.search"
                        placeholder="Search brands..."
                        class="min-w-[220px]"
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

                <Button as-child>
                    <Link :href="brands.create.url()">
                        New Brand
                    </Link>
                </Button>

            </div>

        </div>

        <div class="overflow-hidden rounded-lg border bg-card">

            <table class="min-w-full divide-y divide-border">

                <thead class="bg-muted">

                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Name
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Slug
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Deleted
                        </th>

                        <th class="px-4 py-3 text-right text-sm font-semibold">
                            Actions
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-border">

                    <tr
                        v-for="brand in brandsData.data"
                        :key="brand.id"
                    >

                        <td class="px-4 py-4">
                            {{ brand.name }}
                        </td>

                        <td class="px-4 py-4 text-muted-foreground">
                            {{ brand.slug ?? '-' }}
                        </td>

                        <td class="px-4 py-4">

                            <span
                                v-if="brand.deleted_at"
                                class="rounded-full bg-yellow-100 px-2 py-1 text-xs text-yellow-800"
                            >
                                Yes
                            </span>

                            <span
                                v-else
                                class="rounded-full bg-emerald-100 px-2 py-1 text-xs text-emerald-800"
                            >
                                No
                            </span>

                        </td>

                        <td class="px-4 py-4 text-right">

                            <Link
                                v-if="!brand.deleted_at"
                                :href="brands.edit.url(brand.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                class="ml-4 text-red-600 underline"
                                @click="deleteBrand(brand)"
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
                Showing {{ brandsData.from }} to {{ brandsData.to }}
                of {{ brandsData.total }} brands
            </div>

            <div class="flex gap-2">

                <Link
                    v-if="brandsData.prev_page_url"
                    :href="brandsData.prev_page_url"
                    class="btn btn-secondary"
                >
                    Previous
                </Link>

                <Link
                    v-if="brandsData.next_page_url"
                    :href="brandsData.next_page_url"
                    class="btn btn-secondary"
                >
                    Next
                </Link>

            </div>

        </div>

    </div>
</template>