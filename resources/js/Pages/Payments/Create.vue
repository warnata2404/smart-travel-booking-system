<script setup>
import { computed, onBeforeUnmount, ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

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

/*
|--------------------------------------------------------------------------
| Form
|--------------------------------------------------------------------------
*/

const form = useForm({
    booking_id: null,
    voucher_id: null,
    payment_proof: null,
});

/*
|--------------------------------------------------------------------------
| Image Preview
|--------------------------------------------------------------------------
*/

const paymentProofPreview = ref(null);

function onFileSelect(event) {
    const file = event.files?.[0];

    if (!file) {
        return;
    }

    form.payment_proof = file;

    if (paymentProofPreview.value) {
        URL.revokeObjectURL(paymentProofPreview.value);
    }

    paymentProofPreview.value = URL.createObjectURL(file);
}

onBeforeUnmount(() => {
    if (paymentProofPreview.value) {
        URL.revokeObjectURL(paymentProofPreview.value);
    }
});

/*
|--------------------------------------------------------------------------
| Selected Booking
|--------------------------------------------------------------------------
*/

const selectedBooking = computed(() => {
    return (
        props.bookings.find((booking) => booking.id === form.booking_id) ?? null
    );
});

/*
|--------------------------------------------------------------------------
| Selected Voucher
|--------------------------------------------------------------------------
*/

const selectedVoucher = computed(() => {
    return (
        props.vouchers.find((voucher) => voucher.id === form.voucher_id) ?? null
    );
});

/*
|--------------------------------------------------------------------------
| Payment Summary
|--------------------------------------------------------------------------
*/

const subtotal = computed(() => {
    return Number(selectedBooking.value?.price ?? 0);
});

const discount = computed(() => {
    if (!selectedVoucher.value) {
        return 0;
    }

    return (
        (subtotal.value * Number(selectedVoucher.value.discount_percentage)) /
        100
    );
});

const grandTotal = computed(() => {
    return Math.max(0, subtotal.value - discount.value);
});

/*
|--------------------------------------------------------------------------
| Submit
|--------------------------------------------------------------------------
*/

function submit() {
    if (!form.booking_id) {
        form.setError("booking_id", "Please select a booking.");

        return;
    }

    if (!form.payment_proof) {
        form.setError("payment_proof", "Please upload payment proof.");

        return;
    }

    form.clearErrors("booking_id", "payment_proof");

    form.post(route("payments.store"), {
        preserveScroll: true,
    });
}
</script>

<template>
    <Head title="Create Payment" />

    <Card>
        <template #title> Create Payment </template>

        <template #content>
            <div class="space-y-5">
                <!-- Booking -->

                <div>
                    <label class="mb-2 block font-medium"> Booking </label>

                    <Select
                        v-model="form.booking_id"
                        :options="bookings"
                        optionLabel="booking_number"
                        optionValue="id"
                        placeholder="Select Booking"
                        class="w-full"
                    />

                    <small v-if="form.errors.booking_id" class="text-red-500">
                        {{ form.errors.booking_id }}
                    </small>
                </div>

                <!-- Booking Summary -->

                <div
                    v-if="selectedBooking"
                    class="rounded border p-4 space-y-2 bg-surface-50"
                >
                    <div>
                        <strong>Booking Number</strong>
                    </div>

                    <div>
                        {{ selectedBooking.booking_number }}
                    </div>

                    <div>
                        <strong>Destination</strong>
                    </div>

                    <div>
                        {{ selectedBooking.destination?.name ?? "-" }}
                    </div>

                    <div>
                        <strong>Travel Price</strong>
                    </div>

                    <div>
                        Rp
                        {{
                            Number(selectedBooking.price).toLocaleString(
                                "id-ID",
                            )
                        }}
                    </div>
                </div>

                <!-- Voucher -->

                <div>
                    <label class="mb-2 block font-medium">
                        Voucher (Optional)
                    </label>

                    <Select
                        v-model="form.voucher_id"
                        :options="vouchers"
                        optionLabel="code"
                        optionValue="id"
                        placeholder="Select Voucher"
                        showClear
                        class="w-full"
                    />
                </div>

                <Divider />

                <!-- Payment Summary -->

                <div>
                    <label class="mb-2 block font-medium"> Subtotal </label>

                    <InputNumber
                        :modelValue="subtotal"
                        mode="currency"
                        currency="IDR"
                        locale="id-ID"
                        readonly
                        fluid
                    />
                </div>

                <div>
                    <label class="mb-2 block font-medium"> Discount </label>

                    <InputNumber
                        :modelValue="discount"
                        mode="currency"
                        currency="IDR"
                        locale="id-ID"
                        readonly
                        fluid
                    />
                </div>

                <div>
                    <label class="mb-2 block font-medium"> Grand Total </label>

                    <InputNumber
                        :modelValue="grandTotal"
                        mode="currency"
                        currency="IDR"
                        locale="id-ID"
                        readonly
                        fluid
                    />
                </div>

                <Divider />

                <!-- Payment Proof -->

                <div>
                    <label class="mb-2 block font-medium">
                        Payment Proof
                    </label>

                    <FileUpload
                        mode="basic"
                        customUpload
                        chooseLabel="Choose Image"
                        accept="image/*"
                        :maxFileSize="5242880"
                        @select="onFileSelect"
                    />

                    <small
                        v-if="form.errors.payment_proof"
                        class="text-red-500"
                    >
                        {{ form.errors.payment_proof }}
                    </small>
                </div>

                <!-- Preview -->

                <div v-if="paymentProofPreview" class="rounded border p-3">
                    <div class="mb-2 font-medium">Payment Proof Preview</div>

                    <img
                        :src="paymentProofPreview"
                        alt="Payment Proof"
                        class="max-h-80 rounded border"
                    />
                </div>

                <Divider />

                <!-- Submit -->

                <Button
                    label="Pay Now"
                    icon="pi pi-credit-card"
                    :loading="form.processing"
                    type="button"
                    class="w-full"
                    @click="submit"
                />
            </div>
        </template>
    </Card>
</template>
