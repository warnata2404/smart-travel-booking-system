<script setup>
import { Head, Link } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import AppPageHeader from "@/Components/Page/AppPageHeader.vue";
import AppPageToolbar from "@/Components/Page/AppPageToolbar.vue";
import AppPageCard from "@/Components/Page/AppPageCard.vue";

import AppDataTable from "@/Components/Table/AppDataTable.vue";
import AppStatusTag from "@/Components/Table/AppStatusTag.vue";

import Button from "primevue/button";
import Column from "primevue/column";

defineOptions({
    layout: MainLayout,
});

defineProps({
    bookings: {
        type: Array,
        default: () => [],
    },
});

function formatCurrency(value) {
    if (value === null || value === undefined) {
        return "-";
    }

    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(Number(value));
}

function formatDate(value) {
    if (!value) {
        return "-";
    }

    return new Intl.DateTimeFormat("id-ID", {
        dateStyle: "medium",
    }).format(new Date(value));
}

function formatTime(value) {
    if (!value) {
        return "-";
    }

    return String(value).substring(0, 5);
}

function formatDistance(value) {
    if (value === null || value === undefined) {
        return "-";
    }

    return `${Number(value).toFixed(2)} km`;
}
</script>

<template>
    <Head title="Bookings" />

    <div class="space-y-6">
        <AppPageHeader
            title="Booking Management"
            description="Manage customer bookings and monitor their progress from booking creation through payment and trip completion."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('bookings.create')">
                        <Button label="Create Booking" icon="pi pi-plus" />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <AppDataTable :value="bookings" emptyMessage="No bookings found.">
                <Column
                    field="booking_number"
                    header="Booking Number"
                    sortable
                    style="min-width: 180px"
                />

                <Column header="Customer" style="min-width: 180px">
                    <template #body="{ data }">
                        {{ data.customer?.name ?? "-" }}
                    </template>
                </Column>

                <Column header="Origin City" sortable style="min-width: 160px">
                    <template #body="{ data }">
                        {{ data.origin_city?.name ?? "-" }}
                    </template>
                </Column>

                <Column header="Destination" style="min-width: 180px">
                    <template #body="{ data }">
                        {{ data.destination?.name ?? "-" }}
                    </template>
                </Column>

                <Column header="Destination City" style="min-width: 180px">
                    <template #body="{ data }">
                        {{ data.destination?.city?.name ?? "-" }}
                    </template>
                </Column>

                <Column
                    field="departure_date"
                    header="Departure Date"
                    sortable
                    style="min-width: 140px"
                >
                    <template #body="{ data }">
                        {{ formatDate(data.departure_date) }}
                    </template>
                </Column>

                <Column
                    field="departure_time"
                    header="Departure Time"
                    style="min-width: 120px"
                >
                    <template #body="{ data }">
                        {{ formatTime(data.departure_time) }}
                    </template>
                </Column>

                <Column header="Distance" sortable style="min-width: 120px">
                    <template #body="{ data }">
                        {{ formatDistance(data.distance) }}
                    </template>
                </Column>

                <Column
                    field="estimated_duration"
                    header="Duration"
                    sortable
                    style="min-width: 120px"
                >
                    <template #body="{ data }">
                        {{ data.estimated_duration ?? "-" }} minutes
                    </template>
                </Column>

                <Column
                    field="price"
                    header="Price"
                    sortable
                    style="min-width: 150px"
                >
                    <template #body="{ data }">
                        {{ formatCurrency(data.price) }}
                    </template>
                </Column>

                <Column
                    field="status"
                    header="Status"
                    sortable
                    style="width: 170px"
                >
                    <template #body="{ data }">
                        <AppStatusTag :status="data.status" />
                    </template>
                </Column>

                <Column header="Action" style="width: 120px">
                    <template #body="{ data }">
                        <Link :href="route('bookings.show', data.id)">
                            <Button icon="pi pi-eye" severity="info" outlined />
                        </Link>
                    </template>
                </Column>
            </AppDataTable>
        </AppPageCard>
    </div>
</template>
