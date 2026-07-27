<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';

import customers from '@/routes/customers';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import InputError from '@/components/InputError.vue';



const form = useForm({

    name: '',

    code: '',

    email: '',

    phone: '',

    address: '',

    contact_person: '',

    notes: '',

});



function submit() {

    form.post(
        customers.store.url()
    );

}

</script>


<template>

<Head title="Create Customer" />


<form
    class="space-y-8"
    @submit.prevent="submit"
>



<div>

<h1 class="text-2xl font-semibold">
Create Customer
</h1>


<p class="text-sm text-muted-foreground">
Add a new customer.
</p>


</div>




<div class="rounded-lg border p-6">


<h2 class="mb-6 text-lg font-semibold">
Customer Information
</h2>




<div class="grid gap-6 md:grid-cols-2">



<div class="space-y-2">

<Label>
Name
</Label>


<Input
    v-model="form.name"
    placeholder="Customer name"
/>


<InputError
    :message="form.errors.name"
/>


</div>





<div class="space-y-2">

<Label>
Code
</Label>


<Input
    v-model="form.code"
    placeholder="Customer code"
/>


<InputError
    :message="form.errors.code"
/>


</div>





<div class="space-y-2">

<Label>
Email
</Label>


<Input
    type="email"
    v-model="form.email"
    placeholder="Email address"
/>


<InputError
    :message="form.errors.email"
/>


</div>





<div class="space-y-2">

<Label>
Phone
</Label>


<Input
    v-model="form.phone"
    placeholder="Phone number"
/>


<InputError
    :message="form.errors.phone"
/>


</div>





<div class="space-y-2">

<Label>
Contact Person
</Label>


<Input
    v-model="form.contact_person"
    placeholder="Contact person"
/>


<InputError
    :message="form.errors.contact_person"
/>


</div>





<div class="space-y-2 md:col-span-2">


<Label>
Address
</Label>


<textarea

    v-model="form.address"

    rows="3"

    class="w-full rounded-md border bg-background px-3 py-2"

    placeholder="Customer address..."

></textarea>


<InputError
    :message="form.errors.address"
/>


</div>





<div class="space-y-2 md:col-span-2">


<Label>
Notes
</Label>


<textarea

    v-model="form.notes"

    rows="4"

    class="w-full rounded-md border bg-background px-3 py-2"

    placeholder="Notes..."

></textarea>


<InputError
    :message="form.errors.notes"
/>


</div>




</div>


</div>





<div class="flex justify-end gap-3">


<Button

    type="button"

    variant="outline"

    @click="$inertia.visit(
        customers.index.url()
    )"

>

Cancel

</Button>




<Button

    type="submit"

    :disabled="form.processing"

>

Create Customer

</Button>


</div>



</form>


</template>