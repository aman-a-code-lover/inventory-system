<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface Brand {
    id?: number;
    name?: string;
    slug?: string;
    description?: string;
}

const props = defineProps<{
    form: ReturnType<typeof useForm>;
    submit: () => void;
    submitLabel?: string;
}>();
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">

        <div class="space-y-2">
            <Label for="name">Name</Label>

            <Input
                id="name"
                v-model="form.name"
                placeholder="Enter brand name"
            />

            <InputError :message="form.errors.name" />
        </div>

        <div class="space-y-2">
            <Label for="slug">Slug</Label>

            <Input
                id="slug"
                v-model="form.slug"
                placeholder="Leave empty to auto generate"
            />

            <InputError :message="form.errors.slug" />
        </div>

        <div class="space-y-2">
            <Label for="description">Description</Label>

            <textarea
                v-model="form.description"
                rows="4"
                class="w-full rounded-md border bg-background px-3 py-2"
                placeholder="Description..."
            />

            <InputError :message="form.errors.description" />
        </div>

        <div class="flex justify-end">
            <Button type="submit">
                {{ submitLabel ?? 'Save' }}
            </Button>
        </div>

    </form>
</template>