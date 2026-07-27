<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';

import purchasePayments from '@/routes/purchase-payments';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const page = usePage();

const props = page.props as {
    payments: any;
    filters: {
        search?: string;
    };
};

const form = useForm({
    search: props.filters.search || '',
});

const paymentsData = computed(() => props.payments);

function submitSearch() {
    form.get(
        purchasePayments.index.url({
            query: {
                search: form.search,
            },
        }),
        {
            preserveState: true,
            replace: true,
        },
    );
}

function resetSearch() {
    form.search = '';
    submitSearch();
}

function deletePayment(payment: { id: number }) {
    if (!confirm('Are you sure you want to delete this payment?')) {
        return;
    }

    router.delete(
        purchasePayments.destroy.url(payment.id),
        {
            preserveState: true,
        },
    );
}
</script>

<template>

<Head title="Purchase Payments" />

<div class="space-y-6">

<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

<div>

<h1 class="text-2xl font-semibold">
Purchase Payments
</h1>

<p class="text-sm text-muted-foreground">
Manage purchase payments.
</p>

</div>

<div class="flex flex-col gap-2 sm:flex-row sm:items-center">

<form
    class="flex items-center gap-2"
    @submit.prevent="submitSearch"
>

<Label>
Search
</Label>

<Input
    v-model="form.search"
    placeholder="Search Purchase"
/>

<Button type="submit">
Search
</Button>

<Button
    type="button"
    variant="secondary"
    @click="resetSearch"
>
Reset
</Button>

</form>

<Link :href="purchasePayments.create.url()">

<Button>
New Payment
</Button>

</Link>

</div>

</div>

<div class="overflow-hidden rounded-lg border bg-card">

<table class="min-w-full divide-y divide-border">

<thead class="bg-muted">

<tr>

<th class="px-4 py-3 text-left">
Purchase
</th>

<th class="px-4 py-3 text-left">
Amount
</th>

<th class="px-4 py-3 text-left">
Method
</th>

<th class="px-4 py-3 text-left">
Paid At
</th>

<th class="px-4 py-3 text-right">
Actions
</th>

</tr>

</thead>

<tbody class="divide-y divide-border">
                        <tr
                        v-for="payment in paymentsData.data"
                        :key="payment.id"
                    >

                        <td class="px-4 py-4">
                            {{ payment.purchase?.reference_no }}
                        </td>

                        <td class="px-4 py-4">
                            {{ payment.amount }}
                        </td>

                        <td class="px-4 py-4">
                            {{ payment.method ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ payment.paid_at ?? '-' }}
                        </td>

                        <td class="px-4 py-4 text-right">

                            <Link
                                :href="purchasePayments.edit.url(payment.id)"
                                class="text-primary underline"
                            >
                                Edit
                            </Link>

                            <button
                                type="button"
                                class="ml-4 text-red-600 underline"
                                @click="deletePayment(payment)"
                            >
                                Delete
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        <div class="flex items-center justify-between">

            <div class="text-sm text-muted-foreground">

                Showing

                {{ paymentsData.from }}

                to

                {{ paymentsData.to }}

                of

                {{ paymentsData.total }}

                payments

            </div>

            <div class="flex gap-2">

                <Link
                    v-if="paymentsData.prev_page_url"
                    :href="paymentsData.prev_page_url"
                >
                    <Button variant="secondary">
                        Previous
                    </Button>
                </Link>

                <Link
                    v-if="paymentsData.next_page_url"
                    :href="paymentsData.next_page_url"
                >
                    <Button variant="secondary">
                        Next
                    </Button>
                </Link>

            </div>

        </div>

    </div>

</template>