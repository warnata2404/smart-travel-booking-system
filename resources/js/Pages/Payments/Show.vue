<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";

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
                @click="$inertia.visit(route('payments.index'))"
            />
        </div>

        <Card>
            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
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

                <div>
                    <strong>Payment Proof</strong>

                    <div class="mt-3">
                        <img
                            v-if="payment.payment_proof"
                            :src="`/storage/${payment.payment_proof}`"
                            alt="Payment Proof"
                            class="max-w-md rounded border"
                        />

                        <span v-else> No payment proof uploaded. </span>
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>
