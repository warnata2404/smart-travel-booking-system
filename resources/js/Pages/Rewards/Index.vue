<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";

import Card from "primevue/card";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Button from "primevue/button";
import Tag from "primevue/tag";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    rewards: {
        type: Array,
        default: () => [],
    },
});

function viewReward(id) {
    window.location.href = route("rewards.show", id);
}

function formatDistance(distance) {
    if (distance === null || distance === undefined) {
        return "-";
    }

    return `${Number(distance).toFixed(2)} km`;
}

function formatDate(date) {
    if (!date) {
        return "-";
    }

    return new Date(date).toLocaleString("id-ID");
}
</script>

<template>
    <Head title="Rewards" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">Rewards</h1>

            <p class="mt-1 text-gray-500">View customer rewards.</p>
        </div>

        <Card>
            <template #content>
                <DataTable
                    :value="props.rewards"
                    paginator
                    :rows="10"
                    stripedRows
                    responsiveLayout="scroll"
                    dataKey="id"
                >
                    <Column header="Customer">
                        <template #body="{ data }">
                            {{ data.customer?.name ?? "-" }}
                        </template>
                    </Column>

                    <Column header="Reward">
                        <template #body="{ data }">
                            {{ data.reward_configuration?.reward_name ?? "-" }}
                        </template>
                    </Column>

                    <Column header="Distance">
                        <template #body="{ data }">
                            {{ formatDistance(data.total_distance) }}
                        </template>
                    </Column>

                    <Column header="Generated At">
                        <template #body="{ data }">
                            {{ formatDate(data.generated_at) }}
                        </template>
                    </Column>

                    <Column header="Voucher">
                        <template #body="{ data }">
                            <Tag
                                v-if="data.voucher"
                                value="Generated"
                                severity="success"
                            />

                            <Tag
                                v-else
                                value="Not Generated"
                                severity="secondary"
                            />
                        </template>
                    </Column>

                    <Column header="Action" style="width: 140px">
                        <template #body="{ data }">
                            <Button
                                label="Detail"
                                icon="pi pi-eye"
                                outlined
                                @click="viewReward(data.id)"
                            />
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </div>
</template>
