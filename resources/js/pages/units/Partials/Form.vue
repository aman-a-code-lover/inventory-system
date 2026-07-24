<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

defineProps<{
    form: ReturnType<typeof useForm>;
    submit: () => void;
    submitLabel?: string;
}>();
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">

        <div class="space-y-2">
            <Label for="code">Code</Label>

            <Input
                id="code"
                v-model="form.code"
                placeholder="Enter unit code"
                required
            />

            <InputError :message="form.errors.code" />
        </div>

        <div class="space-y-2">
            <Label for="name">Name</Label>

            <Input
                id="name"
                v-model="form.name"
                placeholder="Enter unit name"
                required
            />

            <InputError :message="form.errors.name" />
        </div>

        <div class="space-y-2">
            <Label for="precision">Precision</Label>

            <Input
                id="precision"
                type="number"
                min="0"
                max="6"
                v-model="form.precision"
                required
            />

            <InputError :message="form.errors.precision" />
        </div>

        <div class="space-y-2">
            <Label for="description">Description</Label>

            <textarea
                id="description"
                v-model="form.description"
                rows="4"
                class="w-full rounded-md border bg-background px-3 py-2"
                placeholder="Enter unit description"
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