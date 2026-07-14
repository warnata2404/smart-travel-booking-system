<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

import Card from "primevue/card";
import Select from "primevue/select";
import Button from "primevue/button";
import FileUpload from "primevue/fileupload";
import InputNumber from "primevue/inputnumber";
import Divider from "primevue/divider";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    bookings: {
        type: Array,
        default: () => [],
    },

    vouchers: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    booking_id: null,
    voucher_id: null,
    payment_proof: null,
});

function submit() {
    form.post(route("payments.store"));
}

function onFileSelect(event) {
    form.payment_proof = event.files[0];
}

function selectedBooking() {
    return (
        props.bookings.find((booking) => booking.id === form.booking_id) ?? null
    );
}

function selectedVoucher() {
    return (
        props.vouchers.find((voucher) => voucher.id === form.voucher_id) ?? null
    );
}

function subtotal() {
    return Number(selectedBooking()?.price ?? 0);
}

function discount() {
    const voucher = selectedVoucher();

    if (!voucher) {
        return 0;
    }

    return (subtotal() * Number(voucher.discount_percentage)) / 100;
}

function grandTotal() {
    return subtotal() - discount();
}
</script>

<template>
    <Head title="Create Payment" />

    <Card>
        <template #title> Create Payment </template>

        <template #content>
            <div class="space-y-5">
                <div>
                    <label class="mb-2 block"> Booking </label>

                    <Select
                        v-model="form.booking_id"
                        :options="bookings"
                        optionLabel="booking_number"
                        optionValue="id"
                        placeholder="Select Booking"
                        class="w-full"
                    />
                </div>

                <div>
                    <label class="mb-2 block"> Voucher (Optional) </label>

                    <Select
                        v-model="form.voucher_id"
                        :options="vouchers"
                        optionLabel="code"
                        optionValue="id"
                        showClear
                        placeholder="Select Voucher"
                        class="w-full"
                    />
                </div>

                <Divider />

                <div>
                    <label class="mb-2 block"> Subtotal </label>

                    <InputNumber
                        :modelValue="subtotal()"
                        mode="currency"
                        currency="IDR"
                        locale="id-ID"
                        readonly
                        fluid
                    />
                </div>

                <div>
                    <label class="mb-2 block"> Discount </label>

                    <InputNumber
                        :modelValue="discount()"
                        mode="currency"
                        currency="IDR"
                        locale="id-ID"
                        readonly
                        fluid
                    />
                </div>

                <div>
                    <label class="mb-2 block"> Grand Total </label>

                    <InputNumber
                        :modelValue="grandTotal()"
                        mode="currency"
                        currency="IDR"
                        locale="id-ID"
                        readonly
                        fluid
                    />
                </div>

                <Divider />

                <div>
                    <label class="mb-2 block"> Payment Proof </label>

                    <FileUpload
                        mode="basic"
                        customUpload
                        chooseLabel="Choose Image"
                        accept="image/*"
                        :maxFileSize="5242880"
                        @select="onFileSelect"
                    />
                </div>

                <Button
                    label="Pay Now"
                    icon="pi pi-credit-card"
                    :loading="form.processing"
                    @click="submit"
                />
            </div>
        </template>
    </Card>
</template>
