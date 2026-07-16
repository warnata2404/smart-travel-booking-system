<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import AppPageHeader from "@/Components/Page/AppPageHeader.vue";
import AppPageToolbar from "@/Components/Page/AppPageToolbar.vue";
import AppPageCard from "@/Components/Page/AppPageCard.vue";

import AppFormSection from "@/Components/Form/AppFormSection.vue";
import AppFormField from "@/Components/Form/AppFormField.vue";
import AppFormActions from "@/Components/Form/AppFormActions.vue";

import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import Textarea from "primevue/textarea";
import Select from "primevue/select";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },

    cities: {
        type: Array,
        required: true,
    },

    categories: {
        type: Array,
        required: true,
    },

    statuses: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    city_id: props.destination.city_id,
    name: props.destination.name,
    category: props.destination.category,
    price: Number(props.destination.price),
    distance: Number(props.destination.distance),
    estimated_duration: props.destination.estimated_duration,
    description: props.destination.description ?? "",
    status: props.destination.status,
});

function submit() {
    form.put(route("destinations.update", props.destination.id));
}
</script>

<template>
    <Head title="Edit Destination" />

    <div class="space-y-6">
        <AppPageHeader
            title="Edit Destination"
            description="Update destination information."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('destinations.index')">
                        <Button label="Back" icon="pi pi-arrow-left" outlined />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <form @submit.prevent="submit">
                <AppFormSection
                    title="Destination Information"
                    description="Update the destination information below."
                >
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <AppFormField
                            label="City"
                            :error="form.errors.city_id"
                            required
                        >
                            <Select
                                v-model="form.city_id"
                                :options="cities"
                                optionLabel="name"
                                optionValue="id"
                                fluid
                            />
                        </AppFormField>

                        <AppFormField
                            label="Destination Name"
                            :error="form.errors.name"
                            required
                        >
                            <InputText v-model="form.name" fluid />
                        </AppFormField>

                        <AppFormField
                            label="Category"
                            :error="form.errors.category"
                            required
                        >
                            <Select
                                v-model="form.category"
                                :options="categories"
                                optionLabel="label"
                                optionValue="value"
                                fluid
                            />
                        </AppFormField>

                        <AppFormField
                            label="Price"
                            :error="form.errors.price"
                            required
                        >
                            <InputNumber
                                v-model="form.price"
                                mode="currency"
                                currency="IDR"
                                locale="id-ID"
                                fluid
                            />
                        </AppFormField>

                        <AppFormField
                            label="Distance (km)"
                            :error="form.errors.distance"
                            required
                        >
                            <InputNumber
                                v-model="form.distance"
                                :minFractionDigits="2"
                                :maxFractionDigits="2"
                                fluid
                            />
                        </AppFormField>

                        <AppFormField
                            label="Estimated Duration (minutes)"
                            :error="form.errors.estimated_duration"
                            required
                        >
                            <InputNumber
                                v-model="form.estimated_duration"
                                :min="1"
                                fluid
                            />
                        </AppFormField>
                    </div>

                    <AppFormField
                        label="Description"
                        :error="form.errors.description"
                    >
                        <Textarea v-model="form.description" rows="4" fluid />
                    </AppFormField>

                    <AppFormField
                        label="Status"
                        :error="form.errors.status"
                        required
                    >
                        <Select
                            v-model="form.status"
                            :options="statuses"
                            optionLabel="label"
                            optionValue="value"
                            fluid
                        />
                    </AppFormField>
                </AppFormSection>

                <AppFormActions>
                    <Link :href="route('destinations.index')">
                        <Button label="Cancel" severity="secondary" outlined />
                    </Link>

                    <Button
                        type="submit"
                        label="Update"
                        icon="pi pi-save"
                        :loading="form.processing"
                    />
                </AppFormActions>
            </form>
        </AppPageCard>
    </div>
</template>
