<script setup>
import { Head, router } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

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

/*
|--------------------------------------------------------------------------
| Navigation
|--------------------------------------------------------------------------
*/

function goToCreate() {
    router.visit(route("payments.create"));
}

function goToDetail(id) {
    router.visit(route("payments.show", id));
}

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function formatCurrency(value) {
    if (value === null || value === undefined) {
        return "-";
    }

    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
}

function formatDate(value) {
    if (!value) {
        return "-";
    }

    return new Date(value).toLocaleString("id-ID");
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

            <Button label="New Payment" icon="pi pi-plus" @click="goToCreate" />
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
                    sortMode="single"
                    removableSort
                >
                    <template #empty> No payment data available. </template>

                    <Column field="payment_number" header="Payment No" sortable>
                        <template #body="{ data }">
                            {{ data.payment_number }}
                        </template>
                    </Column>

                    <Column header="Booking" sortable>
                        <template #body="{ data }">
                            {{ data.booking?.booking_number ?? "-" }}
                        </template>
                    </Column>

                    <Column header="Customer" sortable>
                        <template #body="{ data }">
                            {{ data.booking?.customer?.name ?? "-" }}
                        </template>
                    </Column>

                    <Column header="Origin">
                        <template #body="{ data }">
                            {{
                                data.booking?.originCity?.name ??
                                data.booking?.origin_city?.name ??
                                "-"
                            }}
                        </template>
                    </Column>

                    <Column header="Destination">
                        <template #body="{ data }">
                            {{ data.booking?.destination?.name ?? "-" }}
                        </template>
                    </Column>

                    <Column field="grand_total" header="Grand Total" sortable>
                        <template #body="{ data }">
                            {{ formatCurrency(data.grand_total) }}
                        </template>
                    </Column>

                    <Column field="status" header="Status" sortable>
                        <template #body="{ data }">
                            <Tag
                                :value="data.status"
                                :severity="statusSeverity(data.status)"
                            />
                        </template>
                    </Column>

                    <Column field="paid_at" header="Paid At" sortable>
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
                                @click="goToDetail(data.id)"
                            />
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </div>
</template>
