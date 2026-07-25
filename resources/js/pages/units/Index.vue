<script setup lang="ts">
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import units from '@/routes/units';

const page = usePage();

const props = page.props as {
    units: any;
    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search || '',
});

const unitsData = computed(() => props.units);

function submitSearch() {
    form.get(
        units.index.url({
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

function deleteUnit(unit: { id: number }) {
    if (!confirm('Are you sure you want to delete this unit?')) {
        return;
    }

    router.delete(units.destroy.url(unit.id), {
        preserveState: true,
    });
}
</script>

<template>
    <Head title="Units" />

    <div class="space-y-6">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="text-2xl font-semibold">Units</h1>
                <p class="text-sm text-muted-foreground">
                    Manage measurement units.
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
                        placeholder="Search units..."
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
                    <Link :href="units.create.url()">
                        New Unit
                    </Link>
                </Button>

            </div>

        </div>

        <div class="overflow-hidden rounded-lg border bg-card">

            <table class="min-w-full divide-y divide-border">

                <thead class="bg-muted">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Code
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Name
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Precision
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
                        v-for="unit in unitsData.data"
                        :key="unit.id"
                    >
                        <td class="px-4 py-4">
                            {{ unit.code }}
                        </td>

                        <td class="px-4 py-4">
                            {{ unit.name }}
                        </td>

                        <td class="px-4 py-4">
                            {{ unit.precision }}
                        </td>

                        <td class="px-4 py-4">

                            <span
                                v-if="unit.deleted_at"
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
                                v-if="!unit.deleted_at"
                                :href="units.edit.url(unit.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                class="ml-4 text-red-600 underline"
                                @click="deleteUnit(unit)"
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
                Showing {{ unitsData.from }} to {{ unitsData.to }}
                of {{ unitsData.total }} units
            </div>

            <div class="flex gap-2">

                <Link
                    v-if="unitsData.prev_page_url"
                    :href="unitsData.prev_page_url"
                    class="btn btn-secondary"
                >
                    Previous
                </Link>

                <Link
                    v-if="unitsData.next_page_url"
                    :href="unitsData.next_page_url"
                    class="btn btn-secondary"
                >
                    Next
                </Link>

            </div>

        </div>

    </div>
</template>