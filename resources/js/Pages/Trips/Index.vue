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
    trips: {
        type: Array,
        default: () => [],
    },
});

function viewTrip(id) {
    window.location.href = route("trips.show", id);
}

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

function formatDate(date) {
    if (!date) {
        return "-";
    }

    return new Date(date).toLocaleString("id-ID");
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
                >
                    <Column header="Booking">
                        <template #body="{ data }">
                            {{ data.booking?.booking_number }}
                        </template>
                    </Column>

                    <Column header="Customer">
                        <template #body="{ data }">
                            {{ data.booking?.customer?.name }}
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

                    <Column header="Started">
                        <template #body="{ data }">
                            {{ formatDate(data.started_at) }}
                        </template>
                    </Column>

                    <Column header="Completed">
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
                                @click="viewTrip(data.id)"
                            />
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </div>
</template>
