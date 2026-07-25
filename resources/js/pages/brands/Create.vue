<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';

import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
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
            <h1 class="text-2xl font-semibold">
                Create Brand
            </h1>

            <p class="text-sm text-muted-foreground">
                Add a new product brand.
            </p>
        </div>

        <form
            class="space-y-6"
            @submit.prevent="submit"
        >

            <div class="space-y-2">

                <Label for="name">
                    Name
                </Label>

                <Input
                    id="name"
                    v-model="form.name"
                    placeholder="Enter brand name"
                />

                <InputError :message="form.errors.name" />

            </div>

            <div class="space-y-2">

                <Label for="slug">
                    Slug
                </Label>

                <Input
                    id="slug"
                    v-model="form.slug"
                    placeholder="Leave empty to auto generate"
                />

                <InputError :message="form.errors.slug" />

            </div>

            <div class="space-y-2">

                <Label for="description">
                    Description
                </Label>

                <textarea
                    id="description"
                    v-model="form.description"
                    rows="4"
                    class="w-full rounded-md border border-input bg-background px-3 py-2"
                    placeholder="Description..."
                />

                <InputError :message="form.errors.description" />

            </div>

            <div class="flex justify-end gap-3">

                <Button
                    variant="outline"
                    as-child
                >
                    <Link :href="brands.index.url()">
                        Cancel
                    </Link>
                </Button>

                <Button
                    type="submit"
                    :disabled="form.processing"
                >
                    Create Brand
                </Button>

            </div>

        </form>

    </div>
</template>