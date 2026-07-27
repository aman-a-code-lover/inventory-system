<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import suppliers from '@/routes/suppliers';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const page = usePage();

const props = page.props as {
    suppliers: any;
    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search || '',
});

const suppliersData = computed(() => props.suppliers);

function submitSearch() {
    form.get(
        suppliers.index.url({
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

function deleteSupplier(supplier: { id: number }) {
    if (!confirm('Are you sure you want to delete this supplier?')) {
        return;
    }

    router.delete(suppliers.destroy.url(supplier.id), {
        preserveState: true,
    });
}
</script>

<template>
    <Head title="Suppliers" />

    <div class="space-y-6">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="text-2xl font-semibold">
                    Suppliers
                </h1>

                <p class="text-sm text-muted-foreground">
                    Manage your suppliers.
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">

                <form
                    class="flex items-center gap-2"
                    @submit.prevent="submitSearch"
                >

                    <Label for="search">
                        Search
                    </Label>

                    <Input
                        id="search"
                        v-model="form.search"
                        placeholder="Search supplier..."
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

                <Link
                    :href="suppliers.create.url()"
                >
                    <Button>
                        New Supplier
                    </Button>
                </Link>

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
                            Code
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Contact Person
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Email
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Phone
                        </th>

                        <th class="px-4 py-3 text-right text-sm font-semibold">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-border bg-background">

                    <tr
                        v-for="supplier in suppliersData.data"
                        :key="supplier.id"
                    >

                        <td class="px-4 py-4">
                            {{ supplier.name }}
                        </td>

                        <td class="px-4 py-4">
                            {{ supplier.code ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ supplier.contact_person ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ supplier.email ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ supplier.phone ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-right">

                            <Link
                                :href="suppliers.edit.url(supplier.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                type="button"
                                class="ml-4 text-red-600 underline"
                                @click="deleteSupplier(supplier)"
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

                Showing
                {{ suppliersData.from }}
                to
                {{ suppliersData.to }}
                of
                {{ suppliersData.total }}
                suppliers

            </div>

            <div class="flex gap-2">

                <Link
                    v-if="suppliersData.prev_page_url"
                    :href="suppliersData.prev_page_url"
                >
                    <Button variant="secondary">
                        Previous
                    </Button>
                </Link>

                <Link
                    v-if="suppliersData.next_page_url"
                    :href="suppliersData.next_page_url"
                >
                    <Button variant="secondary">
                        Next
                    </Button>
                </Link>

            </div>

        </div>

    </div>
</template>