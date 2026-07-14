<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

import Card from "primevue/card";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import Select from "primevue/select";
import Message from "primevue/message";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
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
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">
                    Create Reward Configuration
                </h1>

                <p class="mt-1 text-gray-500">
                    Add a new reward configuration.
                </p>
            </div>

            <Link :href="route('reward-configurations.index')">
                <Button label="Back" icon="pi pi-arrow-left" outlined />
            </Link>
        </div>

        <Card>
            <template #content>
                <form class="space-y-6" @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label>Minimum Distance (km)</label>

                            <InputNumber
                                v-model="form.minimum_distance"
                                :min="1"
                                class="w-full"
                            />

                            <Message
                                v-if="form.errors.minimum_distance"
                                severity="error"
                                size="small"
                                variant="simple"
                            >
                                {{ form.errors.minimum_distance }}
                            </Message>
                        </div>

                        <div class="space-y-2">
                            <label>Reward Name</label>

                            <InputText
                                v-model="form.reward_name"
                                class="w-full"
                            />

                            <Message
                                v-if="form.errors.reward_name"
                                severity="error"
                                size="small"
                                variant="simple"
                            >
                                {{ form.errors.reward_name }}
                            </Message>
                        </div>

                        <div class="space-y-2">
                            <label>Discount Percentage</label>

                            <InputNumber
                                v-model="form.discount_percentage"
                                suffix="%"
                                :min="0"
                                :max="100"
                                :minFractionDigits="2"
                                :maxFractionDigits="2"
                                class="w-full"
                            />

                            <Message
                                v-if="form.errors.discount_percentage"
                                severity="error"
                                size="small"
                                variant="simple"
                            >
                                {{ form.errors.discount_percentage }}
                            </Message>
                        </div>

                        <div class="space-y-2">
                            <label>Status</label>

                            <Select
                                v-model="form.status"
                                :options="statuses"
                                optionLabel="label"
                                optionValue="value"
                                class="w-full"
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
                        <Link :href="route('reward-configurations.index')">
                            <Button
                                label="Cancel"
                                severity="secondary"
                                outlined
                            />
                        </Link>

                        <Button
                            type="submit"
                            label="Save"
                            icon="pi pi-save"
                            :loading="form.processing"
                        />
                    </div>
                </form>
            </template>
        </Card>
    </div>
</template>
