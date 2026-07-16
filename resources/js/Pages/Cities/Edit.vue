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
import Textarea from "primevue/textarea";
import Select from "primevue/select";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    city: {
        type: Object,
        required: true,
    },

    statuses: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: props.city.name,
    description: props.city.description ?? "",
    status: props.city.status,
});

function submit() {
    form.put(route("cities.update", props.city.id));
}
</script>

<template>
    <Head title="Edit City" />

    <div class="space-y-6">
        <AppPageHeader title="Edit City" description="Update city information.">
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('cities.index')">
                        <Button label="Back" icon="pi pi-arrow-left" outlined />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <form @submit.prevent="submit">
                <AppFormSection
                    title="City Information"
                    description="Update the city information below."
                >
                    <AppFormField
                        label="City Name"
                        required
                        :error="form.errors.name"
                    >
                        <InputText v-model="form.name" fluid />
                    </AppFormField>

                    <AppFormField
                        label="Description"
                        :error="form.errors.description"
                    >
                        <Textarea v-model="form.description" rows="4" fluid />
                    </AppFormField>

                    <AppFormField
                        label="Status"
                        required
                        :error="form.errors.status"
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

                <AppFormActions
                    :cancel-route="route('cities.index')"
                    submit-label="Update"
                    :loading="form.processing"
                />
            </form>
        </AppPageCard>
    </div>
</template>
