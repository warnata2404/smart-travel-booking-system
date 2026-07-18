<script setup>
import { Head, Link } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import AppPageHeader from "@/Components/Page/AppPageHeader.vue";
import AppPageToolbar from "@/Components/Page/AppPageToolbar.vue";
import AppPageCard from "@/Components/Page/AppPageCard.vue";

import AppFormSection from "@/Components/Form/AppFormSection.vue";

import AppStatusTag from "@/Components/Table/AppStatusTag.vue";

import Button from "primevue/button";

defineOptions({
    layout: MainLayout,
});

defineProps({
    booking: {
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
    <Head title="Booking Detail" />

    <div class="space-y-6">
        <AppPageHeader
            title="Booking Detail"
            description="View the booking information before continuing to the next process."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('bookings.index')">
                        <Button label="Back" icon="pi pi-arrow-left" outlined />
                    </Link>

                    <Link
                        v-if="booking.status === 'PENDING_PAYMENT'"
                        :href="route('payments.create', booking.id)"
                    >
                        <Button
                            label="Proceed to Payment"
                            icon="pi pi-credit-card"
                        />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <AppFormSection
                title="Travel Information"
                description="Travel information associated with this booking."
            >
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <div class="text-sm text-gray-500">Origin City</div>

                        <div class="font-semibold">
                            {{ booking.originCity?.name ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Destination</div>

                        <div class="font-semibold">
                            {{ booking.destination?.name ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Destination City
                        </div>

                        <div class="font-semibold">
                            {{ booking.destination?.city?.name ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Departure Date</div>

                        <div class="font-semibold">
                            {{ formatDate(booking.departure_date) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Departure Time</div>

                        <div class="font-semibold">
                            {{ formatTime(booking.departure_time) }}
                        </div>
                    </div>
                </div>
            </AppFormSection>

            <AppFormSection
                title="Booking Summary"
                description="Summary generated when the booking was created."
            >
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <div class="text-sm text-gray-500">Booking Number</div>

                        <div class="font-semibold">
                            {{ booking.booking_number ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Customer</div>

                        <div class="font-semibold">
                            {{ booking.customer?.name ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Distance</div>

                        <div class="font-semibold">
                            {{ formatDistance(booking.distance) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Estimated Duration
                        </div>

                        <div class="font-semibold">
                            {{ booking.estimated_duration }} minutes
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Price</div>

                        <div class="font-semibold">
                            {{ formatCurrency(booking.price) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Status</div>

                        <AppStatusTag :status="booking.status" />
                    </div>
                </div>
            </AppFormSection>
        </AppPageCard>
    </div>
</template>
