<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

import Card from "primevue/card";
import Button from "primevue/button";
import Select from "primevue/select";
import Calendar from "primevue/calendar";
import Divider from "primevue/divider";
import InputNumber from "primevue/inputnumber";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    cities: {
        type: Array,
        default: () => [],
    },

    destinations: {
        type: Array,
        default: () => [],
    },

    filters: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    origin_city_id: props.filters.origin_city_id ?? null,
    destination_id: props.filters.destination_id ?? null,
    departure_date: props.filters.departure_date ?? null,
    departure_time: props.filters.departure_time ?? null,

    distance: props.filters.distance ?? 0,
    estimated_duration: props.filters.estimated_duration ?? 0,
    price: props.filters.price ?? 0,
});

function submit() {
    form.post(route("bookings.store"));
}
</script>

<template>
    <Head title="Create Booking" />

    <Card>
        <template #title> Create Booking </template>

        <template #content>
            <div class="space-y-5">
                <div>
                    <label class="mb-2 block font-medium"> Origin City </label>

                    <Select
                        v-model="form.origin_city_id"
                        :options="cities"
                        optionLabel="name"
                        optionValue="id"
                        placeholder="Select Origin City"
                        class="w-full"
                    />
                </div>

                <div>
                    <label class="mb-2 block font-medium"> Destination </label>

                    <Select
                        v-model="form.destination_id"
                        :options="destinations"
                        optionLabel="name"
                        optionValue="id"
                        placeholder="Select Destination"
                        class="w-full"
                    />
                </div>

                <div>
                    <label class="mb-2 block font-medium">
                        Departure Date
                    </label>

                    <Calendar
                        v-model="form.departure_date"
                        dateFormat="yy-mm-dd"
                        showIcon
                        class="w-full"
                    />
                </div>

                <div>
                    <label class="mb-2 block font-medium">
                        Departure Time
                    </label>

                    <Calendar
                        v-model="form.departure_time"
                        timeOnly
                        hourFormat="24"
                        showIcon
                        class="w-full"
                    />
                </div>

                <Divider />

                <h3 class="text-lg font-semibold">Travel Summary</h3>

                <div>
                    <label class="mb-2 block font-medium">
                        Distance (KM)
                    </label>

                    <InputNumber
                        v-model="form.distance"
                        disabled
                        class="w-full"
                    />
                </div>

                <div>
                    <label class="mb-2 block font-medium">
                        Estimated Duration (Minutes)
                    </label>

                    <InputNumber
                        v-model="form.estimated_duration"
                        disabled
                        class="w-full"
                    />
                </div>

                <div>
                    <label class="mb-2 block font-medium">
                        Estimated Price
                    </label>

                    <InputNumber
                        v-model="form.price"
                        mode="currency"
                        currency="IDR"
                        locale="id-ID"
                        disabled
                        class="w-full"
                    />
                </div>

                <Divider />

                <Button
                    label="Create Booking"
                    icon="pi pi-check"
                    severity="success"
                    :loading="form.processing"
                    @click="submit"
                />
            </div>
        </template>
    </Card>
</template>
