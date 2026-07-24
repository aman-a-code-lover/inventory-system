<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import UnitForm from './Partials/Form.vue';
import units from '@/routes/units';

interface Unit {
    id: number;
    code: string;
    name: string;
    description: string | null;
    precision: number;
}

const props = defineProps<{
    unit: Unit;
}>();

const form = useForm({
    code: props.unit.code,
    name: props.unit.name,
    description: props.unit.description ?? '',
    precision: props.unit.precision,
});

function submit() {
    form.put(units.update.url(props.unit.id));
}
</script>

<template>
    <Head title="Edit Unit" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">Edit Unit</h1>
            <p class="text-sm text-muted-foreground">
                Update measurement unit.
            </p>
        </div>

        <UnitForm
            :form="form"
            :submit="submit"
            submit-label="Update Unit"
        />
    </div>
</template>