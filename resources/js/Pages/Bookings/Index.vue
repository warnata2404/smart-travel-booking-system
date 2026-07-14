<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import Card from "primevue/card";

defineOptions({
    layout: MainLayout,
});

defineProps({
    bookings: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Bookings" />

    <Card>
        <template #title> Booking List </template>

        <template #content>
            <div class="mb-4 flex justify-end">
                <Link :href="route('bookings.create')">
                    <Button label="New Booking" icon="pi pi-plus" />
                </Link>
            </div>

            <DataTable
                :value="bookings"
                stripedRows
                paginator
                :rows="10"
                responsiveLayout="scroll"
            >
                <Column field="booking_number" header="Booking Number" />

                <Column field="customer.name" header="Customer" />

                <Column field="origin_city.name" header="Origin" />

                <Column field="destination.name" header="Destination" />

                <Column field="price" header="Price" />

                <Column field="status" header="Status" />

                <Column header="Action">
                    <template #body="{ data }">
                        <Link :href="route('bookings.show', data.id)">
                            <Button icon="pi pi-eye" severity="info" outlined />
                        </Link>
                    </template>
                </Column>
            </DataTable>
        </template>
    </Card>
</template>
