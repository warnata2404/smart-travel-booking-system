<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import AppPageHeader from "@/Components/Page/AppPageHeader.vue";
import AppPageCard from "@/Components/Page/AppPageCard.vue";

import AppFormSection from "@/Components/Form/AppFormSection.vue";
import AppFormField from "@/Components/Form/AppFormField.vue";
import AppFormActions from "@/Components/Form/AppFormActions.vue";

import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import Select from "primevue/select";

defineOptions({
    layout: MainLayout,
});

defineProps({
    statuses: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: "",
    description: "",
    status: "ACTIVE",
});

function submit() {
    form.post(route("cities.store"));
}
</script>

<template>
    <Head title="Create City" />

    <div class="space-y-6">
        <AppPageHeader
            badge="Master Data"
            icon="pi pi-map-marker"
            title="Create City"
            description="Create a new city that can be used throughout the Smart Travel Booking System."
        >
            <template #actions>
                <Link :href="route('cities.index')">
                    <Button
                        label="Back"
                        icon="pi pi-arrow-left"
                        severity="secondary"
                        outlined
                    />
                </Link>
            </template>
        </AppPageHeader>

        <AppPageCard
            title="City Information"
            subtitle="Enter the required information below."
        >
            <form class="space-y-6" @submit.prevent="submit">
                <AppFormSection
                    title="General Information"
                    description="Provide the basic information for the new city."
                    icon="pi pi-map-marker"
                >
                    <AppFormField
                        id="name"
                        label="City Name"
                        required
                        helper="Enter a unique city name."
                        :error="form.errors.name"
                    >
                        <InputText
                            id="name"
                            v-model="form.name"
                            placeholder="Enter city name"
                            autocomplete="off"
                            fluid
                        />
                    </AppFormField>

                    <AppFormField
                        id="description"
                        label="Description"
                        optional
                        helper="Provide additional information if needed."
                        :error="form.errors.description"
                    >
                        <Textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            placeholder="Enter description"
                            autoResize
                            fluid
                        />
                    </AppFormField>

                    <AppFormField
                        id="status"
                        label="Status"
                        required
                        helper="Select the initial status for this city."
                        :error="form.errors.status"
                    >
                        <Select
                            id="status"
                            v-model="form.status"
                            :options="statuses"
                            optionLabel="label"
                            optionValue="value"
                            placeholder="Select status"
                            fluid
                        />
                    </AppFormField>
                </AppFormSection>

                <AppFormActions
                    separator
                    :cancel-route="route('cities.index')"
                    submit-label="Save City"
                    submit-icon="pi pi-save"
                    :loading="form.processing"
                    :submit-disabled="form.processing"
                />
            </form>
        </AppPageCard>
    </div>
</template>
