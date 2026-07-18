<script setup>
import { computed, watch } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import AppPageHeader from "@/Components/Page/AppPageHeader.vue";
import AppPageCard from "@/Components/Page/AppPageCard.vue";

import AppFormSection from "@/Components/Form/AppFormSection.vue";
import AppFormField from "@/Components/Form/AppFormField.vue";
import AppFormActions from "@/Components/Form/AppFormActions.vue";

import Button from "primevue/button";
import Select from "primevue/select";
import DatePicker from "primevue/datepicker";
import Divider from "primevue/divider";
import Tag from "primevue/tag";

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
});

const form = useForm({
    origin_city_id: null,
    destination_id: null,
    departure_date: null,
    departure_time: null,
});

/**
 * Destination list based on selected origin city.
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

/**
 * Reset destination when origin city changes.
 */
watch(
    () => form.origin_city_id,
    () => {
        form.destination_id = null;
    },
);

/**
 * Ensure destination is still valid.
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

/**
 * Convert JavaScript Date to YYYY-MM-DD.
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

/**
 * Convert JavaScript Date to HH:mm.
 */
function formatTime(date) {
    if (!date) {
        return null;
    }

    const hours = String(date.getHours()).padStart(2, "0");

    const minutes = String(date.getMinutes()).padStart(2, "0");

    return `${hours}:${minutes}`;
}

function formatCurrency(value) {
    if (value === null || value === undefined) {
        return "-";
    }

    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(Number(value));
}

function formatDisplayDate(value) {
    if (!value) {
        return "-";
    }

    return new Intl.DateTimeFormat("id-ID", {
        dateStyle: "medium",
    }).format(new Date(value));
}

function formatDisplayTime(value) {
    if (!value) {
        return "-";
    }

    if (typeof value === "string") {
        return value.substring(0, 5);
    }

    return value;
}

/**
 * Submit travel analysis.
 */
function analyze() {
    form.transform((data) => ({
        ...data,

        departure_date: formatDate(data.departure_date),

        departure_time: formatTime(data.departure_time),
    })).post(route("travel-analysis.analyze"));
}

/**
 * Parameters sent to Booking page.
 */
const bookingParameters = computed(() => {
    if (!props.analysisResult) {
        return {};
    }

    return {
        travel_route_id: props.analysisResult.travel_route_id,

        departure_date: props.analysisResult.departure_date,

        departure_time: props.analysisResult.departure_time,
    };
});
</script>

<template>
    <Head title="Travel Analysis" />

    <div class="space-y-6">
        <AppPageHeader
            title="Travel Analysis"
            description="Analyze your travel before making a booking."
        />

        <AppPageCard>
            <form @submit.prevent="analyze">
                <AppFormSection
                    title="Travel Information"
                    description="Select your travel information."
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

                <AppFormActions>
                    <Button
                        type="submit"
                        label="Analyze Travel"
                        icon="pi pi-search"
                        :loading="form.processing"
                    />
                </AppFormActions>
            </form>
        </AppPageCard>

        <AppPageCard v-if="analysisResult">
            <AppFormSection
                title="Analysis Result"
                description="Travel estimation generated by the system."
            >
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <div class="text-sm text-gray-500">Origin City</div>

                        <div class="text-lg font-semibold">
                            {{ analysisResult.origin_city }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Destination</div>

                        <div class="text-lg font-semibold">
                            {{ analysisResult.destination }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Destination City
                        </div>

                        <div class="text-lg font-semibold">
                            {{ analysisResult.destination_city }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Destination Category
                        </div>

                        <Tag :value="analysisResult.destination_category" />
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Departure Date</div>

                        <div class="text-lg font-semibold">
                            {{
                                formatDisplayDate(analysisResult.departure_date)
                            }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Departure Time</div>

                        <div class="text-lg font-semibold">
                            {{
                                formatDisplayTime(analysisResult.departure_time)
                            }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Distance</div>

                        <div class="text-lg font-semibold">
                            {{ analysisResult.distance }} km
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">
                            Estimated Duration
                        </div>

                        <div class="text-lg font-semibold">
                            {{ analysisResult.estimated_duration }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Estimated Price</div>

                        <div class="text-lg font-semibold">
                            {{ formatCurrency(analysisResult.price) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Weather</div>

                        <Tag
                            :value="analysisResult.weather ?? 'N/A'"
                            severity="info"
                        />
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Reward</div>

                        <Tag
                            :value="analysisResult.reward ?? 'No Reward'"
                            :severity="
                                analysisResult.reward ? 'success' : 'secondary'
                            "
                        />
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Discount</div>

                        <div class="text-lg font-semibold">
                            {{
                                analysisResult.discount_percentage !== null
                                    ? `${analysisResult.discount_percentage}%`
                                    : "-"
                            }}
                        </div>
                    </div>

                    <div
                        v-if="analysisResult.recommendation"
                        class="md:col-span-2"
                    >
                        <div class="text-sm text-gray-500">Recommendation</div>

                        <div
                            class="mt-2 rounded-lg border border-green-200 bg-green-50 p-4"
                        >
                            {{ analysisResult.recommendation }}
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="flex justify-end">
                    <Link :href="route('bookings.create', bookingParameters)">
                        <Button
                            label="Continue to Booking"
                            icon="pi pi-arrow-right"
                            severity="success"
                        />
                    </Link>
                </div>
            </AppFormSection>
        </AppPageCard>
    </div>
</template>
