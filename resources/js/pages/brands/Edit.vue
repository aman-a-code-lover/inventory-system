<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';

import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
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
            <h1 class="text-2xl font-semibold">
                Edit Brand
            </h1>

            <p class="text-sm text-muted-foreground">
                Update brand information.
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
                    Update Brand
                </Button>

            </div>

        </form>

    </div>
</template>