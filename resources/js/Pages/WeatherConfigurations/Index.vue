<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

import Card from "primevue/card";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Tag from "primevue/tag";
import { useConfirm } from "primevue/useconfirm";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    weatherConfigurations: {
        type: Array,
        required: true,
    },
});

const confirm = useConfirm();

function statusSeverity(status) {
    return status === "ACTIVE" ? "success" : "danger";
}

function confirmDelete(id) {
    confirm.require({
        message: "Are you sure you want to delete this weather configuration?",
        header: "Delete Confirmation",
        icon: "pi pi-exclamation-triangle",

        accept: () => {
            router.delete(route("weather-configurations.destroy", id));
        },
    });
}
</script>

<template>
    <Head title="Weather Configurations" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">
                    Weather Configuration Management
                </h1>

                <p class="mt-1 text-gray-500">Manage weather analysis rules.</p>
            </div>

            <Link :href="route('weather-configurations.create')">
                <Button label="Add Weather Configuration" icon="pi pi-plus" />
            </Link>
        </div>

        <Card>
            <template #content>
                <DataTable
                    :value="weatherConfigurations"
                    paginator
                    :rows="10"
                    stripedRows
                    responsiveLayout="scroll"
                >
                    <Column field="rule_type" header="Rule Type" />

                    <Column field="weather" header="Weather" />

                    <Column field="recommendation" header="Recommendation" />

                    <Column header="Status">
                        <template #body="{ data }">
                            <Tag
                                :value="data.status"
                                :severity="statusSeverity(data.status)"
                            />
                        </template>
                    </Column>

                    <Column header="Action" style="width: 180px">
                        <template #body="{ data }">
                            <div class="flex gap-2">
                                <Link
                                    :href="
                                        route(
                                            'weather-configurations.edit',
                                            data.id,
                                        )
                                    "
                                >
                                    <Button icon="pi pi-pencil" outlined />
                                </Link>

                                <Button
                                    icon="pi pi-trash"
                                    severity="danger"
                                    outlined
                                    @click="confirmDelete(data.id)"
                                />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </div>
</template>
