<script setup>
import { computed, watch } from "vue";
import { Head, useForm } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";
import Button from "primevue/button";

import AppPageHeader from "@/Components/Page/AppPageHeader.vue";
import AppPageCard from "@/Components/Page/AppPageCard.vue";

import AppFormSection from "@/Components/Form/AppFormSection.vue";
import AppFormField from "@/Components/Form/AppFormField.vue";
import AppFormActions from "@/Components/Form/AppFormActions.vue";

import Select from "primevue/select";
import DatePicker from "primevue/datepicker";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    cities: {
        type: Array,
        default: () => [],
    },

    travelRoutes: {
        type: Array,
        default: () => [],
    },

    analysisResult: {
        type: Object,
        default: null,
    },

    bookingData: {
        type: Object,
        default: null,
    },

    formData: {
        type: Object,
        default: null,
    },
});

/*
|--------------------------------------------------------------------------
| Booking Form
|--------------------------------------------------------------------------
|
| When returning from Trip Analysis, the previous form values are restored
| so the customer does not need to re-enter the information.
|
*/

const form = useForm({
    origin_city_id: props.formData?.origin_city_id ?? null,
    destination_id: props.formData?.destination_id ?? null,

    departure_date: props.formData?.departure_date
        ? new Date(props.formData.departure_date)
        : null,

    departure_time: props.formData?.departure_time
        ? (() => {
              const [hour, minute] = props.formData.departure_time.split(":");

              const date = new Date();

              date.setHours(Number(hour));
              date.setMinutes(Number(minute));
              date.setSeconds(0);

              return date;
          })()
        : null,
});

/*
|--------------------------------------------------------------------------
| Available Destinations
|--------------------------------------------------------------------------
*/

const filteredDestinations = computed(() => {
    if (!form.origin_city_id) {
        return [];
    }

    const routes = props.travelRoutes.filter(
        (route) => route.origin_city_id === form.origin_city_id,
    );

    const destinations = [];

    routes.forEach((route) => {
        const exists = destinations.some(
            (destination) => destination.id === route.destination.id,
        );

        if (!exists) {
            destinations.push(route.destination);
        }
    });

    return destinations.sort((a, b) => a.name.localeCompare(b.name));
});

/*
|--------------------------------------------------------------------------
| Watch Origin City
|--------------------------------------------------------------------------
*/

watch(
    () => form.origin_city_id,
    (value, oldValue) => {
        if (oldValue !== null && value !== oldValue) {
            form.destination_id = null;
        }
    },
);

/*
|--------------------------------------------------------------------------
| Ensure Destination Exists
|--------------------------------------------------------------------------
*/

watch(filteredDestinations, () => {
    if (
        form.destination_id &&
        !filteredDestinations.value.some(
            (destination) => destination.id === form.destination_id,
        )
    ) {
        form.destination_id = null;
    }
});

/*
|--------------------------------------------------------------------------
| Date Formatting
|--------------------------------------------------------------------------
*/

function formatDate(date) {
    if (!date) {
        return null;
    }

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
}

/*
|--------------------------------------------------------------------------
| Time Formatting
|--------------------------------------------------------------------------
*/

function formatTime(date) {
    if (!date) {
        return null;
    }

    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");

    return `${hours}:${minutes}`;
}

/*
|--------------------------------------------------------------------------
| Trip Analysis
|--------------------------------------------------------------------------
*/

function reviewBooking() {
    form.transform((data) => ({
        ...data,
        departure_date: formatDate(data.departure_date),
        departure_time: formatTime(data.departure_time),
    })).post(route("bookings.review"));
}

/*
|--------------------------------------------------------------------------
| Create Booking
|--------------------------------------------------------------------------
*/

function createBooking() {
    useForm({
        travel_route_id: props.bookingData.travel_route_id,
        departure_date: props.bookingData.departure_date,
        departure_time: props.bookingData.departure_time,
    }).post(route("bookings.store"));
}
</script>

<template>
    <Head title="Create Booking" />

    <div class="space-y-6">
        <AppPageHeader
            title="Create Booking"
            description="Enter your travel information to analyze your trip before creating a booking."
        />

        <AppPageCard>
            <form v-if="!analysisResult" @submit.prevent="reviewBooking">
                <AppFormSection
                    title="Travel Information"
                    description="Select the origin city, destination, departure date, and departure time."
                >
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <AppFormField
                            label="Origin City"
                            :error="form.errors.origin_city_id"
                            required
                        >
                            <Select
                                v-model="form.origin_city_id"
                                :options="cities"
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select Origin City"
                                filter
                                fluid
                            />
                        </AppFormField>

                        <AppFormField
                            label="Destination"
                            :error="form.errors.destination_id"
                            required
                        >
                            <Select
                                v-model="form.destination_id"
                                :options="filteredDestinations"
                                optionLabel="name"
                                optionValue="id"
                                placeholder="Select Destination"
                                :disabled="!form.origin_city_id"
                                filter
                                fluid
                            />
                        </AppFormField>

                        <AppFormField
                            label="Departure Date"
                            :error="form.errors.departure_date"
                            required
                        >
                            <DatePicker
                                v-model="form.departure_date"
                                showIcon
                                :manualInput="false"
                                :minDate="new Date()"
                                dateFormat="yy-mm-dd"
                                fluid
                            />
                        </AppFormField>

                        <AppFormField
                            label="Departure Time"
                            :error="form.errors.departure_time"
                            required
                        >
                            <DatePicker
                                v-model="form.departure_time"
                                timeOnly
                                hourFormat="24"
                                :manualInput="false"
                                showIcon
                                fluid
                            />
                        </AppFormField>
                    </div>
                </AppFormSection>

                <AppFormActions
                    submit-label="Trip Analysis"
                    submit-icon="pi pi-search"
                    submit-severity="info"
                    :loading="form.processing"
                />
            </form>

            <div v-else class="space-y-8">
                <AppFormSection
                    title="Travel Information"
                    description="Review your selected travel information."
                >
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <div class="text-sm text-surface-500">
                                Origin City
                            </div>

                            <div class="font-semibold">
                                {{ analysisResult.origin_city }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-surface-500">
                                Destination
                            </div>

                            <div class="font-semibold">
                                {{ analysisResult.destination }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-surface-500">
                                Departure Date
                            </div>

                            <div class="font-semibold">
                                {{ analysisResult.departure_date }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-surface-500">
                                Departure Time
                            </div>

                            <div class="font-semibold">
                                {{ analysisResult.departure_time }}
                            </div>
                        </div>
                    </div>
                </AppFormSection>

                <AppFormSection
                    title="Route Analysis"
                    description="Travel route information."
                >
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <div class="text-sm text-surface-500">
                                Destination City
                            </div>

                            <div class="font-semibold">
                                {{ analysisResult.destination_city }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-surface-500">Category</div>

                            <div class="font-semibold">
                                {{ analysisResult.destination_category }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-surface-500">Distance</div>

                            <div class="font-semibold">
                                {{ analysisResult.distance }} km
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-surface-500">
                                Estimated Duration
                            </div>

                            <div class="font-semibold">
                                {{ analysisResult.estimated_duration }}
                                Minutes
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-surface-500">Price</div>

                            <div class="font-semibold">
                                Rp
                                {{
                                    Number(analysisResult.price).toLocaleString(
                                        "id-ID",
                                    )
                                }}
                            </div>
                        </div>
                    </div>
                </AppFormSection>

                <AppFormSection
                    title="Weather Analysis"
                    description="Current travel recommendation."
                >
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <div class="text-sm text-surface-500">Weather</div>

                            <div class="font-semibold">
                                {{ analysisResult.weather ?? "-" }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-surface-500">
                                Recommendation
                            </div>

                            <div class="font-semibold">
                                {{ analysisResult.recommendation ?? "-" }}
                            </div>
                        </div>
                    </div>
                </AppFormSection>

                <AppFormSection
                    title="Reward Analysis"
                    description="Reward available for this trip."
                >
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <div class="text-sm text-surface-500">Reward</div>

                            <div class="font-semibold">
                                {{ analysisResult.reward ?? "-" }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-surface-500">Discount</div>

                            <div class="font-semibold">
                                {{
                                    analysisResult.discount_percentage
                                        ? analysisResult.discount_percentage +
                                          "%"
                                        : "-"
                                }}
                            </div>
                        </div>
                    </div>
                </AppFormSection>

                <AppFormActions>
                    <Button
                        label="Analyze Again"
                        icon="pi pi-arrow-left"
                        severity="secondary"
                        outlined
                        @click="$inertia.get(route('bookings.create'))"
                    />

                    <Button
                        label="Create Booking"
                        icon="pi pi-check"
                        @click="createBooking"
                    />
                </AppFormActions>
            </div>
        </AppPageCard>
    </div>
</template>
