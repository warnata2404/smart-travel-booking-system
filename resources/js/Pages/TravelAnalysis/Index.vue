<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";

import { Head, Link, useForm } from "@inertiajs/vue3";

import Card from "primevue/card";
import Button from "primevue/button";
import Select from "primevue/select";
import Calendar from "primevue/calendar";
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

    destinations: {
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

function analyze() {
    form.post(route("travel-analysis.analyze"));
}
</script>

<template>
    <Head title="Travel Analysis" />

    <Card>
        <template #title> Travel Analysis </template>

        <template #content>
            <div class="grid gap-5">
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

                <Button
                    label="Analyze Travel"
                    icon="pi pi-search"
                    @click="analyze"
                    :loading="form.processing"
                />
            </div>

            <template v-if="analysisResult">
                <Divider />

                <div class="grid gap-4">
                    <div>
                        <strong>Distance</strong>

                        <div>
                            {{ analysisResult.distance }}
                        </div>
                    </div>

                    <div>
                        <strong>Estimated Duration</strong>

                        <div>
                            {{ analysisResult.estimated_duration }}
                        </div>
                    </div>

                    <div>
                        <strong>Estimated Price</strong>

                        <div>
                            {{ analysisResult.price }}
                        </div>
                    </div>

                    <div>
                        <strong>Weather</strong>

                        <div>
                            {{ analysisResult.weather }}
                        </div>
                    </div>

                    <div>
                        <strong>Reward</strong>

                        <div>
                            <Tag
                                :value="analysisResult.reward"
                                severity="success"
                            />
                        </div>
                    </div>

                    <div v-if="analysisResult.recommendation">
                        <strong>Recommendation</strong>

                        <div>
                            {{ analysisResult.recommendation }}
                        </div>
                    </div>
                </div>

                <Divider />

                <div class="flex justify-end">
                    <Link
                        :href="
                            route('bookings.create', {
                                origin_city_id: form.origin_city_id,
                                destination_id: form.destination_id,
                                departure_date: form.departure_date,
                                departure_time: form.departure_time,
                                distance: analysisResult.distance,
                                estimated_duration:
                                    analysisResult.estimated_duration,
                                price: analysisResult.price,
                            })
                        "
                    >
                        <Button
                            label="Book Now"
                            icon="pi pi-arrow-right"
                            severity="success"
                        />
                    </Link>
                </div>
            </template>
        </template>
    </Card>
</template>
