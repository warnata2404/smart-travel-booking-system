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
import Tag from "primevue/tag";

import { useConfirm } from "primevue/useconfirm";

defineOptions({
    layout: MainLayout,
});

defineProps({
    destinations: {
        type: Array,
        required: true,
    },
});

const confirm = useConfirm();

function deleteDestination(destination) {
    confirm.require({
        header: "Delete Destination",
        message: `Are you sure you want to delete "${destination.name}"?`,
        icon: "pi pi-exclamation-triangle",

        acceptClass: "p-button-danger",

        accept: () => {
            router.delete(route("destinations.destroy", destination.id));
        },
    });
}

function formatCurrency(value) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
}

function categorySeverity(category) {
    switch (category) {
        case "INDOOR":
            return "info";

        case "OUTDOOR":
            return "warning";

        default:
            return "secondary";
    }
}
</script>

<template>
    <Head title="Destinations" />

    <div class="space-y-6">
        <AppPageHeader
            title="Destination Management"
            description="Manage travel destinations."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('destinations.create')">
                        <Button label="Add Destination" icon="pi pi-plus" />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <AppDataTable
                :value="destinations"
                emptyMessage="No destinations found."
            >
                <Column field="name" header="Destination" sortable />

                <Column header="City" sortable>
                    <template #body="{ data }">
                        {{ data.city.name }}
                    </template>
                </Column>

                <Column header="Category" style="width: 140px">
                    <template #body="{ data }">
                        <Tag
                            :value="data.category"
                            :severity="categorySeverity(data.category)"
                        />
                    </template>
                </Column>

                <Column header="Price" sortable>
                    <template #body="{ data }">
                        {{ formatCurrency(data.price) }}
                    </template>
                </Column>

                <Column header="Distance" sortable>
                    <template #body="{ data }">
                        {{ data.distance }} km
                    </template>
                </Column>

                <Column header="Duration" sortable>
                    <template #body="{ data }">
                        {{ data.estimated_duration }}
                        minutes
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
                            <Link :href="route('destinations.edit', data.id)">
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
                                @click="deleteDestination(data)"
                            />
                        </div>
                    </template>
                </Column>
            </AppDataTable>
        </AppPageCard>
    </div>
</template>
