<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';

import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import categories from '@/routes/categories';

const page = usePage();

const parentOptions = computed(() => page.props.parentCategories ?? []);

const form = useForm({
    name: '',
    slug: '',
    description: '',
    parent_id: '',
});

function submit() {
    form.post(categories.store.url());
}
</script>

<template>
    <Head title="Create Category" />

    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-semibold">
                Create Category
            </h1>

            <p class="text-sm text-muted-foreground">
                Add a new category for your inventory.
            </p>
        </div>

        <form
            class="space-y-6"
            @submit.prevent="submit"
        >

            <div class="grid gap-2">

                <Label for="name">
                    Name
                </Label>

                <Input
                    id="name"
                    v-model="form.name"
                    placeholder="Category name"
                />

                <InputError :message="form.errors.name" />

            </div>

            <div class="grid gap-2">

                <Label for="slug">
                    Slug
                </Label>

                <Input
                    id="slug"
                    v-model="form.slug"
                    placeholder="category-slug"
                />

                <InputError :message="form.errors.slug" />

            </div>

            <div class="grid gap-2">

                <Label for="parent_id">
                    Parent Category
                </Label>

                <select
                    id="parent_id"
                    v-model="form.parent_id"
                    class="rounded-md border border-input bg-background px-3 py-2"
                >
                    <option value="">
                        None
                    </option>

                    <option
                        v-for="parent in parentOptions"
                        :key="parent.id"
                        :value="parent.id"
                    >
                        {{ parent.name }}
                    </option>

                </select>

                <InputError :message="form.errors.parent_id" />

            </div>

            <div class="grid gap-2">

                <Label for="description">
                    Description
                </Label>

                <textarea
                    id="description"
                    v-model="form.description"
                    rows="5"
                    class="rounded-md border border-input bg-background px-3 py-2"
                    placeholder="Category description..."
                />

                <InputError :message="form.errors.description" />

            </div>

            <div class="flex justify-end gap-3">

                <Button
                    variant="outline"
                    as-child
                >
                    <Link :href="categories.index.url()">
                        Cancel
                    </Link>
                </Button>

                <Button
                    type="submit"
                    :disabled="form.processing"
                >
                    Create Category
                </Button>

            </div>

        </form>

    </div>
</template>