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

function statusSeverity(status) {
    return status === "ACTIVE" ? "success" : "danger";
}

function categorySeverity(category) {
    return category === "INDOOR" ? "info" : "warning";
}
</script>

<template>
    <Head title="Destinations" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Destination Management</h1>

                <p class="mt-1 text-gray-500">Manage travel destinations.</p>
            </div>

            <Link :href="route('destinations.create')">
                <Button label="Add Destination" icon="pi pi-plus" />
            </Link>
        </div>

        <Card>
            <template #content>
                <DataTable
                    :value="destinations"
                    paginator
                    :rows="10"
                    stripedRows
                    responsiveLayout="scroll"
                >
                    <Column field="name" header="Destination" />

                    <Column header="City">
                        <template #body="{ data }">
                            {{ data.city.name }}
                        </template>
                    </Column>

                    <Column header="Category">
                        <template #body="{ data }">
                            <Tag
                                :value="data.category"
                                :severity="categorySeverity(data.category)"
                            />
                        </template>
                    </Column>

                    <Column header="Price">
                        <template #body="{ data }">
                            {{ formatCurrency(data.price) }}
                        </template>
                    </Column>

                    <Column header="Distance">
                        <template #body="{ data }">
                            {{ data.distance }} km
                        </template>
                    </Column>

                    <Column header="Duration">
                        <template #body="{ data }">
                            {{ data.estimated_duration }} minutes
                        </template>
                    </Column>

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
                                    :href="route('destinations.edit', data.id)"
                                >
                                    <Button icon="pi pi-pencil" outlined />
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
                </DataTable>
            </template>
        </Card>
    </div>
</template>
