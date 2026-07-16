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
    rule_type: "",
    weather: "",
    recommendation: "",
    status: "ACTIVE",
});

function submit() {
    form.post(route("weather-configurations.store"));
}
</script>

<template>
    <Head title="Create Weather Configuration" />

    <div class="space-y-6">
        <AppPageHeader
            title="Create Weather Configuration"
            description="Add a new weather configuration."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('weather-configurations.index')">
                        <Button label="Back" icon="pi pi-arrow-left" outlined />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <form @submit.prevent="submit">
                <AppFormSection
                    title="Weather Configuration Information"
                    description="Fill in the weather configuration information below."
                >
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <AppFormField
                            label="Rule Type"
                            :error="form.errors.rule_type"
                            required
                        >
                            <InputText v-model="form.rule_type" fluid />
                        </AppFormField>

                        <AppFormField
                            label="Weather"
                            :error="form.errors.weather"
                            required
                        >
                            <InputText v-model="form.weather" fluid />
                        </AppFormField>

                        <div class="md:col-span-2">
                            <AppFormField
                                label="Recommendation"
                                :error="form.errors.recommendation"
                                required
                            >
                                <Textarea
                                    v-model="form.recommendation"
                                    rows="4"
                                    fluid
                                />
                            </AppFormField>
                        </div>

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
                    </div>
                </AppFormSection>

                <AppFormActions>
                    <Link :href="route('weather-configurations.index')">
                        <Button label="Cancel" severity="secondary" outlined />
                    </Link>

                    <Button
                        type="submit"
                        label="Save"
                        icon="pi pi-save"
                        :loading="form.processing"
                    />
                </AppFormActions>
            </form>
        </AppPageCard>
    </div>
</template>
