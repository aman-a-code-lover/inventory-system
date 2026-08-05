<script setup lang="ts">
import { computed } from 'vue';

import { Head, useForm } from '@inertiajs/vue3';

import sales from '@/routes/sales';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import InputError from '@/components/InputError.vue';



interface CustomerOption {
    id: number;
    name: string;
}

interface ProductOption {
    id: number;
    name: string;
}

interface WarehouseOption {
    id: number;
    name: string;
}


const props = defineProps<{
    customers: CustomerOption[];
    warehouses: WarehouseOption[];
    products: ProductOption[];
}>();



const form = useForm({

    customer_id: null as number | null,

    warehouse_id: null as number | null,

    reference_no: '',

    status: 'draft',

    sale_date: '',

    due_date: '',

    total_amount: 0,

    tax_amount: 0,

    discount_amount: 0,

    paid_amount: 0,

    notes: '',

    items: [
        {
            product_id: null as number | null,
            quantity: 1,
            unit_price: 0,
        },
    ],

});

const subtotal = computed(() => {

    return form.items.reduce((total, item) => {

        return (
            total +
            (
                Number(item.quantity) *
                Number(item.unit_price)
            )
        );

    }, 0);

});

const grandTotal = computed(() => {

    return (
        subtotal.value +
        Number(form.tax_amount) -
        Number(form.discount_amount)
    );

});

function addItem() {

    form.items.push({

        product_id: null,

        quantity: 1,

        unit_price: 0,

    });

}

function removeItem(index: number) {

    if (form.items.length === 1) {

        return;

    }

    form.items.splice(index, 1);

}

function submit() {

    form.total_amount = grandTotal.value;

    form.post(
        sales.store.url()
    );

}



</script>


<template>
    <Head title="Create Sale" />
    <form class="space-y-8" @submit.prevent="submit">
        <div>
            <h1 class="text-2xl font-semibold">
                Create Sale
            </h1>
            <p class="text-sm text-muted-foreground">
                Create a new customer sale.
            </p>
        </div>
        <div class="rounded-lg border p-6">
            <h2 class="mb-6 text-lg font-semibold">
                Sale Information
            </h2>
            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-2">
                    <Label>
                        Customer
                    </Label>
                    <select v-model="form.customer_id" class="w-full rounded-md border bg-background px-3 py-2">
                        <option :value="null">
                            Select Customer
                        </option>
                        <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                            {{ customer.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.customer_id" />
                </div>
                <div class="space-y-2">
                    <Label>
                        Reference No
                    </Label>
                    <Input v-model="form.reference_no" placeholder="Sale Reference" />
                    <InputError :message="form.errors.reference_no" />
                </div>
                <div class="space-y-2">
                    <Label>
                        Status
                    </Label>
                    <select v-model="form.status" class="w-full rounded-md border bg-background px-3 py-2">
                        <option value="draft">
                            Draft
                        </option>
                        <option value="completed">
                            Completed
                        </option>
                        <option value="cancelled">
                            Cancelled
                        </option>
                    </select>
                    <InputError :message="form.errors.status" />
                </div>
                <div class="space-y-2">
                    <Label>
                        Warehouse
                    </Label>
                    <select v-model="form.warehouse_id" class="w-full rounded-md border bg-background px-3 py-2">
                        <option :value="null">
                            Select Warehouse
                        </option>
                        <option v-for="warehouse in warehouses" :key="warehouse.id" :value="warehouse.id">
                            {{ warehouse.name }}
                        </option>
                    </select>
                    <InputError :message="form.errors.warehouse_id" />
                </div>
                <div class="space-y-2">
                    <Label>
                        Sale Date
                    </Label>
                    <Input type="date" v-model="form.sale_date" />
                    <InputError :message="form.errors.sale_date" />
                </div>
                <div class="space-y-2">
                    <Label>
                        Due Date
                    </Label>
                    <Input type="date" v-model="form.due_date" />
                    <InputError :message="form.errors.due_date" />
                </div>
                <div class="space-y-2">
                    <Label>
                        Paid Amount
                    </Label>
                    <Input type="number" step="0.01" min="0" v-model="form.paid_amount" />
                    <InputError :message="form.errors.paid_amount" />
                </div>
                <div class="space-y-2">
                    <Label>
                        Tax Amount
                    </Label>
                    <Input type="number" step="0.01" min="0" v-model="form.tax_amount" />
                    <InputError :message="form.errors.tax_amount" />
                </div>
                <div class="space-y-2">
                    <Label>
                        Discount Amount
                    </Label>
                    <Input type="number" step="0.01" min="0" v-model="form.discount_amount" />
                    <InputError :message="form.errors.discount_amount" />
                </div>
            
                <div class="space-y-2 md:col-span-2">
                    <Label>
                        Notes
                    </Label>
                    <textarea v-model="form.notes" rows="4" class="w-full rounded-md border bg-background px-3 py-2"
                        placeholder="Notes..."></textarea>
                    <InputError :message="form.errors.notes" />
                </div>
            </div>
        </div>
        <div class="rounded-lg border p-6">

            <div class="mb-6 flex items-center justify-between">

                <h2 class="text-lg font-semibold">
                    Sale Items
                </h2>

                <Button type="button" @click="addItem">
                    Add Item
                </Button>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full border-collapse">

                    <thead>

                        <tr class="border-b">

                            <th class="p-2 text-left">
                                Product
                            </th>

                            <th class="p-2 text-right">
                                Qty
                            </th>

                            <th class="p-2 text-right">
                                Unit Price
                            </th>

                            <th class="p-2 text-right">
                                Total
                            </th>

                            <th class="w-24 p-2"></th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr v-for="(item, index) in form.items" :key="index" class="border-b">

                            <td class="p-2">

                                <select v-model="item.product_id"
                                    class="w-full rounded-md border bg-background px-3 py-2">

                                    <option :value="null">
                                        Select Product
                                    </option>

                                    <option v-for="product in props.products" :key="product.id" :value="product.id">
                                        {{ product.name }}
                                    </option>

                                </select>

                            </td>

                            <td class="p-2">

                                <Input type="number" min="1" step="0.0001" v-model="item.quantity" />

                            </td>

                            <td class="p-2">

                                <Input type="number" min="0" step="0.01" v-model="item.unit_price" />

                            </td>

                            <td class="p-2 text-right font-medium">

                                {{
                                    (
                                        Number(item.quantity) *
                                        Number(item.unit_price)
                                    ).toFixed(2)
                                }}

                            </td>

                            <td class="p-2">

                                <Button type="button" variant="destructive" @click="removeItem(index)">
                                    Remove
                                </Button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
        <div class="rounded-lg border p-6">

            <h2 class="mb-6 text-lg font-semibold">
                Sale Summary
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <div class="space-y-2">

                    <Label>Subtotal</Label>

                    <Input :model-value="subtotal.toFixed(2)" readonly />

                </div>

                <div class="space-y-2">

                    <Label>Tax Amount</Label>

                    <Input type="number" step="0.01" min="0" v-model="form.tax_amount" />

                </div>

                <div class="space-y-2">

                    <Label>Discount Amount</Label>

                    <Input type="number" step="0.01" min="0" v-model="form.discount_amount" />

                </div>

                <div class="space-y-2">

                    <Label>Grand Total</Label>

                    <Input :model-value="grandTotal.toFixed(2)" readonly />

                </div>

                <div class="space-y-2">

                    <Label>Paid Amount</Label>

                    <Input type="number" step="0.01" min="0" v-model="form.paid_amount" />

                </div>

            </div>

        </div>
        <div class="flex justify-end gap-3">
            <Button type="button" variant="outline" @click="$inertia.visit(
                sales.index.url()
            )">
                Cancel
            </Button>
            <Button type="submit" :disabled="form.processing">
                Create Sale
            </Button>
        </div>
    </form>
</template>