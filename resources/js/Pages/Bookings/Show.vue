<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";

import Card from "primevue/card";
import Tag from "primevue/tag";

defineOptions({
    layout: MainLayout,
});

defineProps({
    booking: Object,
});
</script>

<template>
    <Head title="Booking Detail" />

    <Card>
        <template #title> Booking Detail </template>

        <template #content>
            <div class="grid gap-4">
                <div>
                    <strong>Booking Number</strong><br />
                    {{ booking.booking_number }}
                </div>

                <div>
                    <strong>Customer</strong><br />
                    {{ booking.customer?.name }}
                </div>

                <div>
                    <strong>Origin City</strong><br />
                    {{ booking.origin_city?.name }}
                </div>

                <div>
                    <strong>Destination</strong><br />
                    {{ booking.destination?.name }}
                </div>

                <div>
                    <strong>Price</strong><br />
                    {{ booking.price }}
                </div>

                <div>
                    <strong>Distance</strong><br />
                    {{ booking.distance }}
                </div>

                <div>
                    <strong>Departure Date</strong><br />
                    {{ booking.departure_date }}
                </div>

                <div>
                    <strong>Departure Time</strong><br />
                    {{ booking.departure_time }}
                </div>

                <div>
                    <strong>Status</strong><br />

                    <Tag :value="booking.status" />
                </div>
            </div>
        </template>
    </Card>
</template>
