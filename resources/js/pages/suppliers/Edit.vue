<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import suppliers from '@/routes/suppliers';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface Supplier {
    id: number;
    name: string;
    code: string | null;
    email: string | null;
    phone: string | null;
    website: string | null;
    contact_person: string | null;
    address: string | null;
    notes: string | null;
}

const props = defineProps<{
    supplier: Supplier;
}>();

const form = useForm({
    name: props.supplier.name,
    code: props.supplier.code ?? '',
    email: props.supplier.email ?? '',
    phone: props.supplier.phone ?? '',
    website: props.supplier.website ?? '',
    contact_person: props.supplier.contact_person ?? '',
    address: props.supplier.address ?? '',
    notes: props.supplier.notes ?? '',
});

function submit() {
    form.put(suppliers.update.url(props.supplier.id));
}
</script>

<template>
    <Head title="Edit Supplier" />

    <form
        @submit.prevent="submit"
        class="space-y-8"
    >
        <div>
            <h1 class="text-2xl font-semibold">
                Edit Supplier
            </h1>

            <p class="text-sm text-muted-foreground">
                Update supplier information.
            </p>
        </div>

        <div class="rounded-lg border p-6">
            <h2 class="mb-6 text-lg font-semibold">
                Supplier Information
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <div class="space-y-2">
                    <Label for="name">
                        Supplier Name
                    </Label>

                    <Input
                        id="name"
                        v-model="form.name"
                        placeholder="Supplier name"
                    />

                    <InputError :message="form.errors.name" />
                </div>

                <div class="space-y-2">
                    <Label for="code">
                        Supplier Code
                    </Label>

                    <Input
                        id="code"
                        v-model="form.code"
                        placeholder="SUP-001"
                    />

                    <InputError :message="form.errors.code" />
                </div>

                <div class="space-y-2">
                    <Label for="email">
                        Email
                    </Label>

                    <Input
                        id="email"
                        type="email"
                        v-model="form.email"
                        placeholder="supplier@example.com"
                    />

                    <InputError :message="form.errors.email" />
                </div>

                <div class="space-y-2">
                    <Label for="phone">
                        Phone
                    </Label>

                    <Input
                        id="phone"
                        v-model="form.phone"
                        placeholder="+44..."
                    />

                    <InputError :message="form.errors.phone" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <Label for="website">
                        Website
                    </Label>

                    <Input
                        id="website"
                        v-model="form.website"
                        placeholder="https://example.com"
                    />

                    <InputError :message="form.errors.website" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <Label for="contact_person">
                        Contact Person
                    </Label>

                    <Input
                        id="contact_person"
                        v-model="form.contact_person"
                        placeholder="John Smith"
                    />

                    <InputError :message="form.errors.contact_person" />
                </div>
                                <div class="space-y-2 md:col-span-2">
                    <Label for="address">
                        Address
                    </Label>

                    <textarea
                        id="address"
                        v-model="form.address"
                        rows="4"
                        class="w-full rounded-md border bg-background px-3 py-2"
                        placeholder="Supplier address"
                    />

                    <InputError :message="form.errors.address" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <Label for="notes">
                        Notes
                    </Label>

                    <textarea
                        id="notes"
                        v-model="form.notes"
                        rows="4"
                        class="w-full rounded-md border bg-background px-3 py-2"
                        placeholder="Additional notes..."
                    />

                    <InputError :message="form.errors.notes" />
                </div>

            </div>
        </div>

        <div class="flex justify-end gap-3">

            <Button
                type="button"
                variant="outline"
                @click="$inertia.visit(suppliers.index.url())"
            >
                Cancel
            </Button>

            <Button
                type="submit"
                :disabled="form.processing"
            >
                Update Supplier
            </Button>

        </div>

    </form>
</template>