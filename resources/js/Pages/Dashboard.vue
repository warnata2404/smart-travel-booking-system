<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";

import Card from "primevue/card";
import Button from "primevue/button";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    summary: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold">Dashboard</h1>

            <p class="text-gray-500 mt-2">
                Smart Travel Booking System Summary
            </p>
        </div>

        <!-- ===================================================== -->
        <!-- TOTAL -->
        <!-- ===================================================== -->

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <Card>
                <template #title>Total Bookings</template>
                <template #content>
                    <div class="text-3xl font-bold">
                        {{ summary.totalBookings }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Total Payments</template>
                <template #content>
                    <div class="text-3xl font-bold">
                        {{ summary.totalPayments }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Total Trips</template>
                <template #content>
                    <div class="text-3xl font-bold">
                        {{ summary.totalTrips }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Total Rewards</template>
                <template #content>
                    <div class="text-3xl font-bold">
                        {{ summary.totalRewards }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Total Vouchers</template>
                <template #content>
                    <div class="text-3xl font-bold">
                        {{ summary.totalVouchers }}
                    </div>
                </template>
            </Card>
        </div>

        <!-- ===================================================== -->
        <!-- BOOKING -->
        <!-- ===================================================== -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <Card>
                <template #title>Pending Payment</template>

                <template #content>
                    <div class="text-2xl font-semibold">
                        {{ summary.pendingBookings }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Confirmed</template>

                <template #content>
                    <div class="text-2xl font-semibold">
                        {{ summary.confirmedBookings }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Completed</template>

                <template #content>
                    <div class="text-2xl font-semibold">
                        {{ summary.completedBookings }}
                    </div>
                </template>
            </Card>
        </div>

        <!-- ===================================================== -->
        <!-- TRIP -->
        <!-- ===================================================== -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <Card>
                <template #title>Trip Not Started</template>

                <template #content>
                    <div class="text-2xl font-semibold">
                        {{ summary.notStartedTrips }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Trip On Going</template>

                <template #content>
                    <div class="text-2xl font-semibold">
                        {{ summary.onGoingTrips }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Trip Completed</template>

                <template #content>
                    <div class="text-2xl font-semibold">
                        {{ summary.completedTrips }}
                    </div>
                </template>
            </Card>
        </div>

        <!-- ===================================================== -->
        <!-- VOUCHER -->
        <!-- ===================================================== -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <Card>
                <template #title>Voucher Active</template>

                <template #content>
                    <div class="text-2xl font-semibold">
                        {{ summary.activeVouchers }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Voucher Used</template>

                <template #content>
                    <div class="text-2xl font-semibold">
                        {{ summary.usedVouchers }}
                    </div>
                </template>
            </Card>

            <Card>
                <template #title>Voucher Expired</template>

                <template #content>
                    <div class="text-2xl font-semibold">
                        {{ summary.expiredVouchers }}
                    </div>
                </template>
            </Card>
        </div>

        <!-- ===================================================== -->
        <!-- QUICK ACCESS -->
        <!-- ===================================================== -->

        <Card>
            <template #title> Quick Access </template>

            <template #content>
                <div class="flex flex-wrap gap-3">
                    <Button
                        label="Travel Analysis"
                        icon="pi pi-compass"
                        @click="$inertia.visit(route('travel-analysis.index'))"
                    />

                    <Button
                        label="Bookings"
                        icon="pi pi-calendar"
                        @click="$inertia.visit(route('bookings.index'))"
                    />

                    <Button
                        label="Payments"
                        icon="pi pi-credit-card"
                        @click="$inertia.visit(route('payments.index'))"
                    />

                    <Button
                        label="Trips"
                        icon="pi pi-map"
                        @click="$inertia.visit(route('trips.index'))"
                    />

                    <Button
                        label="Rewards"
                        icon="pi pi-star"
                        @click="$inertia.visit(route('rewards.index'))"
                    />

                    <Button
                        label="Vouchers"
                        icon="pi pi-ticket"
                        @click="$inertia.visit(route('vouchers.index'))"
                    />
                </div>
            </template>
        </Card>
    </div>
</template>
