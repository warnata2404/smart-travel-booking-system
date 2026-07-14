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
    rewardConfigurations: {
        type: Array,
        required: true,
    },
});

const confirm = useConfirm();

function statusSeverity(status) {
    return status === "ACTIVE" ? "success" : "danger";
}

function formatDiscount(value) {
    return `${Number(value)} %`;
}

function confirmDelete(id) {
    confirm.require({
        message: "Are you sure you want to delete this reward configuration?",
        header: "Delete Confirmation",
        icon: "pi pi-exclamation-triangle",

        accept: () => {
            router.delete(route("reward-configurations.destroy", id));
        },
    });
}
</script>

<template>
    <Head title="Reward Configurations" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">
                    Reward Configuration Management
                </h1>

                <p class="mt-1 text-gray-500">
                    Manage reward configuration based on travel distance.
                </p>
            </div>

            <Link :href="route('reward-configurations.create')">
                <Button label="Add Reward Configuration" icon="pi pi-plus" />
            </Link>
        </div>

        <Card>
            <template #content>
                <DataTable
                    :value="rewardConfigurations"
                    paginator
                    :rows="10"
                    stripedRows
                    responsiveLayout="scroll"
                >
                    <Column
                        field="minimum_distance"
                        header="Minimum Distance (km)"
                    />

                    <Column field="reward_name" header="Reward Name" />

                    <Column header="Discount">
                        <template #body="{ data }">
                            {{ formatDiscount(data.discount_percentage) }}
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
                                    :href="
                                        route(
                                            'reward-configurations.edit',
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
