<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

import units from '@/routes/units';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface Unit {
    id: number;
    code: string;
    name: string;
    precision: number;
    description: string | null;
}

const props = defineProps<{
    unit: Unit;
}>();

const form = useForm({
    code: props.unit.code,
    name: props.unit.name,
    precision: props.unit.precision,
    description: props.unit.description ?? '',
});

function submit() {
    form.put(units.update.url(props.unit.id));
}
</script>

<template>
    <Head title="Edit Unit" />

    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-semibold">
                Edit Unit
            </h1>

            <p class="text-sm text-muted-foreground">
                Update unit information.
            </p>
        </div>

        <form
            class="space-y-6"
            @submit.prevent="submit"
        >

            <div class="space-y-2">

                <Label for="code">
                    Code
                </Label>

                <Input
                    id="code"
                    v-model="form.code"
                />

                <InputError :message="form.errors.code" />

            </div>

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

                <Label for="precision">
                    Precision
                </Label>

                <Input
                    id="precision"
                    type="number"
                    min="0"
                    max="6"
                    v-model="form.precision"
                />

                <InputError :message="form.errors.precision" />

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
                    <Link :href="units.index.url()">
                        Cancel
                    </Link>
                </Button>

                <Button
                    type="submit"
                    :disabled="form.processing"
                >
                    Update Unit
                </Button>

            </div>

        </form>

    </div>
</template>