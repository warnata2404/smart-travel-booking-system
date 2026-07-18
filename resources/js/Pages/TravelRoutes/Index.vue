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
    travelRoutes: {
        type: Array,
        required: true,
    },
});

const confirm = useConfirm();

function deleteTravelRoute(travelRoute) {
    confirm.require({
        header: "Delete Travel Route",

        message: "Are you sure you want to delete this travel route?",

        icon: "pi pi-exclamation-triangle",

        acceptClass: "p-button-danger",

        accept: () => {
            router.delete(route("travel-routes.destroy", travelRoute.id));
        },
    });
}

function formatCurrency(value) {
    if (value === null || value === undefined) {
        return "-";
    }

    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(Number(value));
}

function destinationLabel(destination) {
    return [destination.city?.name, destination.name, destination.category]
        .filter(Boolean)
        .join(" • ");
}
</script>

<template>
    <Head title="Travel Routes" />

    <div class="space-y-6">
        <AppPageHeader
            title="Travel Route Management"
            description="Manage travel routes between origin city and destination."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('travel-routes.create')">
                        <Button label="Add Travel Route" icon="pi pi-plus" />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <AppDataTable
                :value="travelRoutes"
                emptyMessage="No travel routes found."
            >
                <Column header="Origin City" sortable>
                    <template #body="{ data }">
                        {{ data.origin_city?.name ?? "-" }}
                    </template>
                </Column>

                <Column header="Destination" style="min-width: 260px">
                    <template #body="{ data }">
                        {{ destinationLabel(data.destination) }}
                    </template>
                </Column>

                <Column field="distance" header="Distance" sortable>
                    <template #body="{ data }">
                        {{ Number(data.distance).toFixed(2) }} km
                    </template>
                </Column>

                <Column field="estimated_duration" header="Duration" sortable>
                    <template #body="{ data }">
                        {{ data.estimated_duration }} minutes
                    </template>
                </Column>

                <Column field="base_price" header="Base Price" sortable>
                    <template #body="{ data }">
                        {{ formatCurrency(data.base_price) }}
                    </template>
                </Column>

                <Column header="Status" style="width: 140px">
                    <template #body="{ data }">
                        <AppStatusTag :status="data.status" />
                    </template>
                </Column>

                <Column header="Actions" style="width: 170px">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <Link :href="route('travel-routes.edit', data.id)">
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
                                @click="deleteTravelRoute(data)"
                            />
                        </div>
                    </template>
                </Column>
            </AppDataTable>
        </AppPageCard>
    </div>
</template>
