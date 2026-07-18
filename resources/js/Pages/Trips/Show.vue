<script setup>
import { computed } from "vue";
import { Head, router, useForm } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

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

/*
|--------------------------------------------------------------------------
| Forms
|--------------------------------------------------------------------------
*/

const startForm = useForm({});
const completeForm = useForm({});

/*
|--------------------------------------------------------------------------
| Computed
|--------------------------------------------------------------------------
*/

const canStart = computed(() => {
    return props.trip.status === "NOT_STARTED";
});

const canComplete = computed(() => {
    return props.trip.status === "ON_GOING";
});

/*
|--------------------------------------------------------------------------
| Navigation
|--------------------------------------------------------------------------
*/

function goBack() {
    router.visit(route("trips.index"));
}

/*
|--------------------------------------------------------------------------
| Actions
|--------------------------------------------------------------------------
*/

function startTrip() {
    startForm.post(route("trips.start", props.trip.id), {
        preserveScroll: true,
    });
}

function completeTrip() {
    completeForm.post(route("trips.complete", props.trip.id), {
        preserveScroll: true,
    });
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

function formatDistance(value) {
    if (value === null || value === undefined) {
        return "-";
    }

    return `${Number(value).toFixed(2)} km`;
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
                @click="goBack"
            />
        </div>

        <Card>
            <template #content>
                <!-- Trip Information -->

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <strong>Booking Number</strong>

                        <div>
                            {{ trip.booking?.booking_number ?? "-" }}
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
                            {{ trip.booking?.customer?.name ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <strong>Origin City</strong>

                        <div>
                            {{
                                trip.booking?.originCity?.name ??
                                trip.booking?.origin_city?.name ??
                                "-"
                            }}
                        </div>
                    </div>

                    <div>
                        <strong>Destination</strong>

                        <div>
                            {{ trip.booking?.destination?.name ?? "-" }}
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

                <!-- Reward -->

                <div
                    v-if="trip.reward"
                    class="grid grid-cols-1 gap-5 md:grid-cols-2"
                >
                    <div>
                        <strong>Reward Point</strong>

                        <div>
                            {{ trip.reward.points ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <strong>Voucher</strong>

                        <div>
                            {{ trip.reward.voucher?.code ?? "-" }}
                        </div>
                    </div>
                </div>

                <Divider v-if="trip.reward" />

                <!-- Actions -->

                <div class="flex gap-3">
                    <Button
                        v-if="canStart"
                        label="Start Trip"
                        icon="pi pi-play"
                        :loading="startForm.processing"
                        @click="startTrip"
                    />

                    <Button
                        v-if="canComplete"
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
