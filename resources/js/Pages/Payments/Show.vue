<script setup>
import { computed } from "vue";
import { Head, router } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import Card from "primevue/card";
import Divider from "primevue/divider";
import Button from "primevue/button";
import Tag from "primevue/tag";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    payment: {
        type: Object,
        required: true,
    },
});

/*
|--------------------------------------------------------------------------
| Computed
|--------------------------------------------------------------------------
*/

const paymentProofUrl = computed(() => {
    if (!props.payment.payment_proof) {
        return null;
    }

    return `/storage/${props.payment.payment_proof}`;
});

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function goBack() {
    router.visit(route("payments.index"));
}

function formatCurrency(value) {
    if (value === null || value === undefined) {
        return "-";
    }

    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
}

function formatDate(date) {
    if (!date) {
        return "-";
    }

    return new Date(date).toLocaleString("id-ID");
}

function statusSeverity(status) {
    switch (status) {
        case "PAID":
            return "success";

        case "PENDING":
            return "warn";

        default:
            return "secondary";
    }
}
</script>

<template>
    <Head title="Payment Detail" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Payment Detail</h1>

                <p class="mt-1 text-gray-500">Payment information.</p>
            </div>

            <Button
                label="Back"
                icon="pi pi-arrow-left"
                outlined
                @click="goBack"
            />
        </div>

        <Card>
            <template #content>
                <!-- Payment Information -->

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <strong>Payment Number</strong>

                        <div>
                            {{ payment.payment_number }}
                        </div>
                    </div>

                    <div>
                        <strong>Status</strong>

                        <div>
                            <Tag
                                :value="payment.status"
                                :severity="statusSeverity(payment.status)"
                            />
                        </div>
                    </div>

                    <div>
                        <strong>Booking Number</strong>

                        <div>
                            {{ payment.booking?.booking_number ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <strong>Customer</strong>

                        <div>
                            {{ payment.booking?.customer?.name ?? "-" }}
                        </div>
                    </div>
                </div>

                <Divider />

                <!-- Travel Information -->

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <strong>Origin City</strong>

                        <div>
                            {{ payment.booking?.origin_city?.name ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <strong>Destination</strong>

                        <div>
                            {{ payment.booking?.destination?.name ?? "-" }}
                        </div>
                    </div>
                </div>

                <Divider />

                <!-- Payment Summary -->

                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                    <div>
                        <strong>Subtotal</strong>

                        <div>
                            {{ formatCurrency(payment.subtotal) }}
                        </div>
                    </div>

                    <div>
                        <strong>Discount</strong>

                        <div>
                            {{ formatCurrency(payment.discount) }}
                        </div>
                    </div>

                    <div>
                        <strong>Grand Total</strong>

                        <div>
                            {{ formatCurrency(payment.grand_total) }}
                        </div>
                    </div>
                </div>

                <Divider />

                <!-- Voucher -->

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <strong>Voucher</strong>

                        <div>
                            {{ payment.voucher?.code ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <strong>Paid At</strong>

                        <div>
                            {{ formatDate(payment.paid_at) }}
                        </div>
                    </div>
                </div>

                <Divider />

                <!-- Payment Proof -->

                <div>
                    <strong>Payment Proof</strong>

                    <div class="mt-3">
                        <img
                            v-if="paymentProofUrl"
                            :src="paymentProofUrl"
                            alt="Payment Proof"
                            class="max-w-md rounded border"
                        />

                        <div
                            v-else
                            class="rounded border border-dashed p-6 text-center text-gray-500"
                        >
                            No payment proof uploaded.
                        </div>
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>
