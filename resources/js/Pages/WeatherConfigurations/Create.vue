<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

import Card from "primevue/card";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
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
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">
                    Create Weather Configuration
                </h1>

                <p class="mt-1 text-gray-500">
                    Add a new weather configuration.
                </p>
            </div>

            <Link :href="route('weather-configurations.index')">
                <Button label="Back" icon="pi pi-arrow-left" outlined />
            </Link>
        </div>

        <Card>
            <template #content>
                <form class="space-y-6" @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label>Rule Type</label>

                            <InputText
                                v-model="form.rule_type"
                                class="w-full"
                            />

                            <Message
                                v-if="form.errors.rule_type"
                                severity="error"
                                size="small"
                                variant="simple"
                            >
                                {{ form.errors.rule_type }}
                            </Message>
                        </div>

                        <div class="space-y-2">
                            <label>Weather</label>

                            <InputText v-model="form.weather" class="w-full" />

                            <Message
                                v-if="form.errors.weather"
                                severity="error"
                                size="small"
                                variant="simple"
                            >
                                {{ form.errors.weather }}
                            </Message>
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label>Recommendation</label>

                            <Textarea
                                v-model="form.recommendation"
                                rows="4"
                                class="w-full"
                            />

                            <Message
                                v-if="form.errors.recommendation"
                                severity="error"
                                size="small"
                                variant="simple"
                            >
                                {{ form.errors.recommendation }}
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
                        <Link :href="route('weather-configurations.index')">
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
