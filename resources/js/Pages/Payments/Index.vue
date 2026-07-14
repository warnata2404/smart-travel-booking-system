<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";

import Card from "primevue/card";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Button from "primevue/button";
import Tag from "primevue/tag";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    payments: {
        type: Array,
        default: () => [],
    },
});

function viewPayment(id) {
    window.location.href = route("payments.show", id);
}

function createPayment() {
    window.location.href = route("payments.create");
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
    <Head title="Payments" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Payments</h1>

                <p class="mt-1 text-gray-500">Manage booking payments.</p>
            </div>

            <Button
                label="New Payment"
                icon="pi pi-plus"
                @click="createPayment"
            />
        </div>

        <Card>
            <template #content>
                <DataTable
                    :value="payments"
                    paginator
                    :rows="10"
                    stripedRows
                    responsiveLayout="scroll"
                    dataKey="id"
                >
                    <Column header="Payment No">
                        <template #body="{ data }">
                            {{ data.payment_number }}
                        </template>
                    </Column>

                    <Column header="Booking">
                        <template #body="{ data }">
                            {{ data.booking?.booking_number ?? "-" }}
                        </template>
                    </Column>

                    <Column header="Customer">
                        <template #body="{ data }">
                            {{ data.booking?.customer?.name ?? "-" }}
                        </template>
                    </Column>

                    <Column header="Grand Total">
                        <template #body="{ data }">
                            {{ formatCurrency(data.grand_total) }}
                        </template>
                    </Column>

                    <Column header="Status">
                        <template #body="{ data }">
                            <Tag
                                :value="data.status"
                                :severity="statusSeverity(data.status)"
                            />
                        </template>
                    </Column>

                    <Column header="Paid At">
                        <template #body="{ data }">
                            {{ formatDate(data.paid_at) }}
                        </template>
                    </Column>

                    <Column header="Action" style="width: 140px">
                        <template #body="{ data }">
                            <Button
                                label="Detail"
                                icon="pi pi-eye"
                                outlined
                                @click="viewPayment(data.id)"
                            />
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </div>
</template>
