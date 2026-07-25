<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

import units from '@/routes/units';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const form = useForm({
    code: '',
    name: '',
    precision: 4,
    description: '',
});

function submit() {
    form.post(units.store.url());
}
</script>

<template>
    <Head title="Create Unit" />

    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-semibold">
                Create Unit
            </h1>

            <p class="text-sm text-muted-foreground">
                Add a new measurement unit.
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
                    placeholder="PCS"
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
                    placeholder="Pieces"
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
                    placeholder="Description..."
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
                    Create Unit
                </Button>

            </div>

        </form>

    </div>
</template>