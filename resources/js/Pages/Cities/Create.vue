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
        <AppPageHeader title="Create City" description="Add a new city.">
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
                    description="Fill in the city information below."
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
                    submit-label="Save"
                    :loading="form.processing"
                />
            </form>
        </AppPageCard>
    </div>
</template>
