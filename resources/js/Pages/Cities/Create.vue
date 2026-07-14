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
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Create City</h1>

                <p class="mt-1 text-gray-500">Add a new city.</p>
            </div>

            <Link :href="route('cities.index')">
                <Button label="Back" icon="pi pi-arrow-left" outlined />
            </Link>
        </div>

        <Card>
            <template #content>
                <form class="space-y-6" @submit.prevent="submit">
                    <div class="space-y-2">
                        <label class="font-medium"> City Name </label>

                        <InputText v-model="form.name" class="w-full" />

                        <Message
                            v-if="form.errors.name"
                            severity="error"
                            size="small"
                            variant="simple"
                        >
                            {{ form.errors.name }}
                        </Message>
                    </div>

                    <div class="space-y-2">
                        <label class="font-medium"> Description </label>

                        <Textarea
                            v-model="form.description"
                            rows="4"
                            class="w-full"
                        />

                        <Message
                            v-if="form.errors.description"
                            severity="error"
                            size="small"
                            variant="simple"
                        >
                            {{ form.errors.description }}
                        </Message>
                    </div>

                    <div class="space-y-2">
                        <label class="font-medium"> Status </label>

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

                    <div class="flex justify-end gap-3">
                        <Link :href="route('cities.index')">
                            <Button
                                type="button"
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
