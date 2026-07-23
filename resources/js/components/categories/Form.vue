<script setup lang="ts">
import { Link, Form as InertiaForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const props = defineProps<{
    form: Record<string, any>;
    action: string;
    method: 'post' | 'put' | 'patch';
    title: string;
    description: string;
    submitLabel: string;
    backUrl: string;
    parents?: Array<{ id: number; name: string }>;
}>();

const parentOptions = computed(() => props.parents ?? []);
</script>

<template>
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">{{ title }}</h1>
            <p class="text-sm text-muted-foreground">{{ description }}</p>
        </div>

        <InertiaForm :action="action" :method="method" class="space-y-6">
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    name="name"
                    v-model="form.name"
                    required
                    class="mt-1 w-full"
                    placeholder="Category name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="slug">Slug</Label>
                <Input
                    id="slug"
                    name="slug"
                    v-model="form.slug"
                    class="mt-1 w-full"
                    placeholder="Category slug"
                />
                <InputError class="mt-2" :message="form.errors.slug" />
            </div>

            <div class="grid gap-2">
                <Label for="parent_id">Parent category</Label>
                <select
                    id="parent_id"
                    name="parent_id"
                    v-model="form.parent_id"
                    class="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm outline-none transition-colors focus:border-primary focus:ring-1 focus:ring-primary"
                >
                    <option value="">None</option>
                    <option v-for="parent in parentOptions" :key="parent.id" :value="parent.id">
                        {{ parent.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.parent_id" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <textarea
                    id="description"
                    name="description"
                    v-model="form.description"
                    class="mt-1 min-h-[120px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm outline-none transition-colors focus:border-primary focus:ring-1 focus:ring-primary"
                    placeholder="Optional description"
                />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex gap-3">
                    <Button type="submit" :disabled="form.processing">{{ submitLabel }}</Button>
                    <Link :href="backUrl" class="inline-flex items-center rounded-md border border-border px-4 py-2 text-sm font-medium text-foreground transition-colors hover:bg-muted">
                        Cancel
                    </Link>
                </div>
            </div>
        </InertiaForm>
    </div>
</template>
