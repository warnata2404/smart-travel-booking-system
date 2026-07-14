<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

import Card from "primevue/card";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import Tag from "primevue/tag";
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

function statusSeverity(status) {
    return status === "ACTIVE" ? "success" : "danger";
}

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
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">City Management</h1>

                <p class="mt-1 text-gray-500">Manage available cities.</p>
            </div>

            <Link :href="route('cities.create')">
                <Button label="Add City" icon="pi pi-plus" />
            </Link>
        </div>

        <Card>
            <template #content>
                <DataTable
                    :value="cities"
                    paginator
                    :rows="10"
                    stripedRows
                    responsiveLayout="scroll"
                >
                    <Column field="name" header="City" />

                    <Column field="description" header="Description" />

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
                                <Link :href="route('cities.edit', data.id)">
                                    <Button icon="pi pi-pencil" outlined />
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
                </DataTable>
            </template>
        </Card>
    </div>
</template>
