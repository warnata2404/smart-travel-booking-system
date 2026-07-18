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
    trips: {
        type: Array,
        default: () => [],
    },
});

/*
|--------------------------------------------------------------------------
| Navigation
|--------------------------------------------------------------------------
*/

function goToDetail(id) {
    router.visit(route("trips.show", id));
}

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function statusSeverity(status) {
    switch (status) {
        case "NOT_STARTED":
            return "secondary";

        case "ON_GOING":
            return "warn";

        case "COMPLETED":
            return "success";

        default:
            return "secondary";
    }
}

function formatDate(value) {
    if (!value) {
        return "-";
    }

    return new Date(value).toLocaleString("id-ID");
}
</script>

<template>
    <Head title="Trips" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">Trips</h1>

            <p class="mt-1 text-gray-500">Manage customer trips.</p>
        </div>

        <Card>
            <template #content>
                <DataTable
                    :value="trips"
                    paginator
                    :rows="10"
                    stripedRows
                    responsiveLayout="scroll"
                    dataKey="id"
                    sortMode="single"
                    removableSort
                >
                    <template #empty> No trip data available. </template>

                    <Column
                        field="booking.booking_number"
                        header="Booking"
                        sortable
                    >
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

                    <Column field="status" header="Status" sortable>
                        <template #body="{ data }">
                            <Tag
                                :value="data.status"
                                :severity="statusSeverity(data.status)"
                            />
                        </template>
                    </Column>

                    <Column field="started_at" header="Started" sortable>
                        <template #body="{ data }">
                            {{ formatDate(data.started_at) }}
                        </template>
                    </Column>

                    <Column field="completed_at" header="Completed" sortable>
                        <template #body="{ data }">
                            {{ formatDate(data.completed_at) }}
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
