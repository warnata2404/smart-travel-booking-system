<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

import Card from "primevue/card";
import Divider from "primevue/divider";
import Button from "primevue/button";
import Tag from "primevue/tag";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    trip: {
        type: Object,
        required: true,
    },
});

const startForm = useForm({});
const completeForm = useForm({});

function startTrip() {
    startForm.post(route("trips.start", props.trip.id));
}

function completeTrip() {
    completeForm.post(route("trips.complete", props.trip.id));
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

function formatDistance(distance) {
    if (distance === null || distance === undefined) {
        return "-";
    }

    return `${Number(distance).toFixed(2)} km`;
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
</script>

<template>
    <Head title="Trip Detail" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Trip Detail</h1>

                <p class="mt-1 text-gray-500">Customer trip information.</p>
            </div>

            <Button
                label="Back"
                icon="pi pi-arrow-left"
                outlined
                @click="$inertia.visit(route('trips.index'))"
            />
        </div>

        <Card>
            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <strong>Booking Number</strong>

                        <div>
                            {{ trip.booking?.booking_number }}
                        </div>
                    </div>

                    <div>
                        <strong>Status</strong>

                        <div>
                            <Tag
                                :value="trip.status"
                                :severity="statusSeverity(trip.status)"
                            />
                        </div>
                    </div>

                    <div>
                        <strong>Customer</strong>

                        <div>
                            {{ trip.booking?.customer?.name }}
                        </div>
                    </div>

                    <div>
                        <strong>Destination</strong>

                        <div>
                            {{ trip.booking?.destination_name }}
                        </div>
                    </div>

                    <div>
                        <strong>Distance</strong>

                        <div>
                            {{ formatDistance(trip.booking?.distance) }}
                        </div>
                    </div>

                    <div>
                        <strong>Travel Price</strong>

                        <div>
                            {{ formatCurrency(trip.booking?.price) }}
                        </div>
                    </div>

                    <div>
                        <strong>Started At</strong>

                        <div>
                            {{ formatDate(trip.started_at) }}
                        </div>
                    </div>

                    <div>
                        <strong>Completed At</strong>

                        <div>
                            {{ formatDate(trip.completed_at) }}
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="flex gap-3">
                    <Button
                        v-if="trip.status === 'NOT_STARTED'"
                        label="Start Trip"
                        icon="pi pi-play"
                        :loading="startForm.processing"
                        @click="startTrip"
                    />

                    <Button
                        v-if="trip.status === 'ON_GOING'"
                        label="Complete Trip"
                        icon="pi pi-check"
                        severity="success"
                        :loading="completeForm.processing"
                        @click="completeTrip"
                    />
                </div>
            </template>
        </Card>
    </div>
</template>
