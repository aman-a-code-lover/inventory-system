<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import UnitForm from './Partials/Form.vue';
import units from '@/routes/units';

const form = useForm({
    code: '',
    name: '',
    description: '',
    precision: 4,
});

function submit() {
    form.post(units.store.url());
}
</script>

<template>
    <Head title="Create Unit" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">Create Unit</h1>
            <p class="text-sm text-muted-foreground">
                Add a new measurement unit.
            </p>
        </div>

        <UnitForm
            :form="form"
            :submit="submit"
            submit-label="Create Unit"
        />
    </div>
</template>