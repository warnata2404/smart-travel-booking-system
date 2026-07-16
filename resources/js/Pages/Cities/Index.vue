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
    cities: {
        type: Array,
        required: true,
    },
});

const confirm = useConfirm();

function deleteCity(city) {
    confirm.require({
        header: "Delete City",
        message: `Are you sure you want to delete "${city.name}"?`,
        icon: "pi pi-exclamation-triangle",

        acceptClass: "p-button-danger",

        accept: () => {
            router.delete(route("cities.destroy", city.id));
        },
    });
}
</script>

<template>
    <Head title="Cities" />

    <div class="space-y-6">
        <AppPageHeader
            title="City Management"
            description="Manage available cities."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('cities.create')">
                        <Button label="Add City" icon="pi pi-plus" />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <AppDataTable :value="cities" emptyMessage="No cities found.">
                <Column field="name" header="City" sortable />

                <Column field="description" header="Description" />

                <Column header="Status" style="width: 140px">
                    <template #body="{ data }">
                        <AppStatusTag :status="data.status" />
                    </template>
                </Column>

                <Column header="Actions" style="width: 170px">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <Link :href="route('cities.edit', data.id)">
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
                                @click="deleteCity(data)"
                            />
                        </div>
                    </template>
                </Column>
            </AppDataTable>
        </AppPageCard>
    </div>
</template>
