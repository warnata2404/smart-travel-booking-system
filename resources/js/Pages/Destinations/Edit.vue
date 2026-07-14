<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

import Card from "primevue/card";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import Select from "primevue/select";
import InputNumber from "primevue/inputnumber";
import Message from "primevue/message";

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
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Edit Destination</h1>

                <p class="mt-1 text-gray-500">
                    Update destination information.
                </p>
            </div>

            <Link :href="route('destinations.index')">
                <Button label="Back" icon="pi pi-arrow-left" outlined />
            </Link>
        </div>

        <Card>
            <template #content>
                <form class="space-y-6" @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label>City</label>

                            <Select
                                v-model="form.city_id"
                                :options="cities"
                                optionLabel="name"
                                optionValue="id"
                                class="w-full"
                            />

                            <Message
                                v-if="form.errors.city_id"
                                severity="error"
                                size="small"
                                variant="simple"
                            >
                                {{ form.errors.city_id }}
                            </Message>
                        </div>

                        <div class="space-y-2">
                            <label>Destination Name</label>

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
                            <label>Category</label>

                            <Select
                                v-model="form.category"
                                :options="categories"
                                optionLabel="label"
                                optionValue="value"
                                class="w-full"
                            />

                            <Message
                                v-if="form.errors.category"
                                severity="error"
                                size="small"
                                variant="simple"
                            >
                                {{ form.errors.category }}
                            </Message>
                        </div>

                        <div class="space-y-2">
                            <label>Price</label>

                            <InputNumber
                                v-model="form.price"
                                mode="currency"
                                currency="IDR"
                                locale="id-ID"
                                class="w-full"
                            />

                            <Message
                                v-if="form.errors.price"
                                severity="error"
                                size="small"
                                variant="simple"
                            >
                                {{ form.errors.price }}
                            </Message>
                        </div>

                        <div class="space-y-2">
                            <label>Distance (km)</label>

                            <InputNumber
                                v-model="form.distance"
                                :minFractionDigits="2"
                                :maxFractionDigits="2"
                                class="w-full"
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
                                :min="1"
                                class="w-full"
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
                    </div>

                    <div class="space-y-2">
                        <label>Description</label>

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

                    <div class="flex justify-end gap-3">
                        <Link :href="route('destinations.index')">
                            <Button
                                label="Cancel"
                                severity="secondary"
                                outlined
                            />
                        </Link>

                        <Button
                            type="submit"
                            label="Update"
                            icon="pi pi-save"
                            :loading="form.processing"
                        />
                    </div>
                </form>
            </template>
        </Card>
    </div>
</template>
