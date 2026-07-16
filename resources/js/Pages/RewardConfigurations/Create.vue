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
    minimum_distance: null,
    reward_name: "",
    discount_percentage: null,
    status: "ACTIVE",
});

function submit() {
    form.post(route("reward-configurations.store"));
}
</script>

<template>
    <Head title="Create Reward Configuration" />

    <div class="space-y-6">
        <AppPageHeader
            title="Create Reward Configuration"
            description="Add a new reward configuration."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('reward-configurations.index')">
                        <Button label="Back" icon="pi pi-arrow-left" outlined />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <form @submit.prevent="submit">
                <AppFormSection
                    title="Reward Configuration Information"
                    description="Fill in the reward configuration information below."
                >
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <AppFormField
                            label="Minimum Distance (km)"
                            :error="form.errors.minimum_distance"
                            required
                        >
                            <InputNumber
                                v-model="form.minimum_distance"
                                :min="1"
                                fluid
                            />
                        </AppFormField>

                        <AppFormField
                            label="Reward Name"
                            :error="form.errors.reward_name"
                            required
                        >
                            <InputText v-model="form.reward_name" fluid />
                        </AppFormField>

                        <AppFormField
                            label="Discount Percentage"
                            :error="form.errors.discount_percentage"
                            required
                        >
                            <InputNumber
                                v-model="form.discount_percentage"
                                suffix="%"
                                :min="0"
                                :max="100"
                                :minFractionDigits="2"
                                :maxFractionDigits="2"
                                fluid
                            />
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
                    </div>
                </AppFormSection>

                <AppFormActions>
                    <Link :href="route('reward-configurations.index')">
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
