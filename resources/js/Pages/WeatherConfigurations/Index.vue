<script setup>
import { Head, Link, router } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";

import AppPageHeader from "@/Components/Page/AppPageHeader.vue";
import AppPageToolbar from "@/Components/Page/AppPageToolbar.vue";
import AppPageCard from "@/Components/Page/AppPageCard.vue";

import AppDataTable from "@/Components/Table/AppDataTable.vue";
import AppStatusTag from "@/Components/Table/AppStatusTag.vue";

import Button from "primevue/button";
import Column from "primevue/column";

import { useConfirm } from "primevue/useconfirm";

defineOptions({
    layout: MainLayout,
});

defineProps({
    weatherConfigurations: {
        type: Array,
        required: true,
    },
});

const confirm = useConfirm();

function deleteWeatherConfiguration(weatherConfiguration) {
    confirm.require({
        header: "Delete Weather Configuration",
        message: `Are you sure you want to delete "${weatherConfiguration.rule_type}"?`,
        icon: "pi pi-exclamation-triangle",

        acceptClass: "p-button-danger",

        accept: () => {
            router.delete(
                route(
                    "weather-configurations.destroy",
                    weatherConfiguration.id,
                ),
            );
        },
    });
}
</script>

<template>
    <Head title="Weather Configurations" />

    <div class="space-y-6">
        <AppPageHeader
            title="Weather Configuration Management"
            description="Manage weather analysis rules."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('weather-configurations.create')">
                        <Button
                            label="Add Weather Configuration"
                            icon="pi pi-plus"
                        />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <AppDataTable
                :value="weatherConfigurations"
                emptyMessage="No weather configurations found."
            >
                <Column field="rule_type" header="Rule Type" sortable />

                <Column field="weather" header="Weather" sortable />

                <Column field="recommendation" header="Recommendation" />

                <Column header="Status" style="width: 140px">
                    <template #body="{ data }">
                        <AppStatusTag :status="data.status" />
                    </template>
                </Column>

                <Column header="Actions" style="width: 170px">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <Link
                                :href="
                                    route(
                                        'weather-configurations.edit',
                                        data.id,
                                    )
                                "
                            >
                                <Button
                                    icon="pi pi-pencil"
                                    severity="warning"
                                    outlined
                                />
                            </Link>

                            <Button
                                icon="pi pi-trash"
                                severity="danger"
                                outlined
                                @click="deleteWeatherConfiguration(data)"
                            />
                        </div>
                    </template>
                </Column>
            </AppDataTable>
        </AppPageCard>
    </div>
</template>
