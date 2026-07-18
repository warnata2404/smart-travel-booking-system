<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import AppPageHeader from "@/Components/Page/AppPageHeader.vue";
import AppPageToolbar from "@/Components/Page/AppPageToolbar.vue";
import AppPageCard from "@/Components/Page/AppPageCard.vue";

import Button from "primevue/button";
import InputNumber from "primevue/inputnumber";
import Message from "primevue/message";
import Select from "primevue/select";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    cities: {
        type: Array,
        required: true,
    },

    destinations: {
        type: Array,
        required: true,
    },

    statuses: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    origin_city_id: null,
    destination_id: null,
    distance: null,
    estimated_duration: null,
    base_price: null,
    status: "ACTIVE",
});

function destinationLabel(destination) {
    return [destination.city?.name, destination.name, destination.category]
        .filter(Boolean)
        .join(" • ");
}

function submit() {
    form.post(route("travel-routes.store"));
}
</script>

<template>
    <Head title="Create Travel Route" />

    <div class="space-y-6">
        <AppPageHeader
            title="Create Travel Route"
            description="Create a new travel route."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('travel-routes.index')">
                        <Button label="Back" icon="pi pi-arrow-left" outlined />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <form class="space-y-6" @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="space-y-2">
                        <label>Origin City</label>

                        <Select
                            v-model="form.origin_city_id"
                            :options="cities"
                            optionLabel="name"
                            optionValue="id"
                            placeholder="Select Origin City"
                            filter
                            fluid
                        />

                        <Message
                            v-if="form.errors.origin_city_id"
                            severity="error"
                            size="small"
                            variant="simple"
                        >
                            {{ form.errors.origin_city_id }}
                        </Message>
                    </div>

                    <div class="space-y-2">
                        <label>Destination</label>

                        <Select
                            v-model="form.destination_id"
                            :options="destinations"
                            :optionLabel="destinationLabel"
                            optionValue="id"
                            placeholder="Select Destination"
                            filter
                            fluid
                        />

                        <Message
                            v-if="form.errors.destination_id"
                            severity="error"
                            size="small"
                            variant="simple"
                        >
                            {{ form.errors.destination_id }}
                        </Message>
                    </div>

                    <div class="space-y-2">
                        <label>Distance (km)</label>

                        <InputNumber
                            v-model="form.distance"
                            placeholder="Enter distance"
                            :minFractionDigits="2"
                            :maxFractionDigits="2"
                            fluid
                        />

                        <Message
                            v-if="form.errors.distance"
                            severity="error"
                            size="small"
                            variant="simple"
                        >
                            {{ form.errors.distance }}
                        </Message>
                    </div>

                    <div class="space-y-2">
                        <label>Estimated Duration (minutes)</label>

                        <InputNumber
                            v-model="form.estimated_duration"
                            placeholder="Enter estimated duration"
                            :min="1"
                            fluid
                        />

                        <Message
                            v-if="form.errors.estimated_duration"
                            severity="error"
                            size="small"
                            variant="simple"
                        >
                            {{ form.errors.estimated_duration }}
                        </Message>
                    </div>

                    <div class="space-y-2">
                        <label>Base Price</label>

                        <InputNumber
                            v-model="form.base_price"
                            mode="currency"
                            currency="IDR"
                            locale="id-ID"
                            :min="0"
                            :useGrouping="true"
                            placeholder="Enter base price"
                            fluid
                        />

                        <Message
                            v-if="form.errors.base_price"
                            severity="error"
                            size="small"
                            variant="simple"
                        >
                            {{ form.errors.base_price }}
                        </Message>
                    </div>

                    <div class="space-y-2">
                        <label>Status</label>

                        <Select
                            v-model="form.status"
                            :options="statuses"
                            optionLabel="label"
                            optionValue="value"
                            placeholder="Select Status"
                            fluid
                        />

                        <Message
                            v-if="form.errors.status"
                            severity="error"
                            size="small"
                            variant="simple"
                        >
                            {{ form.errors.status }}
                        </Message>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <Link :href="route('travel-routes.index')">
                        <Button label="Cancel" severity="secondary" outlined />
                    </Link>

                    <Button
                        type="submit"
                        label="Save"
                        icon="pi pi-save"
                        :loading="form.processing"
                    />
                </div>
            </form>
        </AppPageCard>
    </div>
</template>
