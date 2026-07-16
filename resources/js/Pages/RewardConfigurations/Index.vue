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
    rewardConfigurations: {
        type: Array,
        required: true,
    },
});

const confirm = useConfirm();

function formatDiscount(value) {
    return `${Number(value)} %`;
}

function deleteRewardConfiguration(rewardConfiguration) {
    confirm.require({
        header: "Delete Reward Configuration",
        message: `Are you sure you want to delete "${rewardConfiguration.reward_name}"?`,
        icon: "pi pi-exclamation-triangle",

        acceptClass: "p-button-danger",

        accept: () => {
            router.delete(
                route("reward-configurations.destroy", rewardConfiguration.id),
            );
        },
    });
}
</script>

<template>
    <Head title="Reward Configurations" />

    <div class="space-y-6">
        <AppPageHeader
            title="Reward Configuration Management"
            description="Manage reward configuration based on travel distance."
        >
            <template #actions>
                <AppPageToolbar>
                    <Link :href="route('reward-configurations.create')">
                        <Button
                            label="Add Reward Configuration"
                            icon="pi pi-plus"
                        />
                    </Link>
                </AppPageToolbar>
            </template>
        </AppPageHeader>

        <AppPageCard>
            <AppDataTable
                :value="rewardConfigurations"
                emptyMessage="No reward configurations found."
            >
                <Column
                    field="minimum_distance"
                    header="Minimum Distance (km)"
                    sortable
                />

                <Column field="reward_name" header="Reward Name" sortable />

                <Column header="Discount" sortable>
                    <template #body="{ data }">
                        {{ formatDiscount(data.discount_percentage) }}
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
                            <Link
                                :href="
                                    route('reward-configurations.edit', data.id)
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
                                @click="deleteRewardConfiguration(data)"
                            />
                        </div>
                    </template>
                </Column>
            </AppDataTable>
        </AppPageCard>
    </div>
</template>
