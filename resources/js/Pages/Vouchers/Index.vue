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
    vouchers: {
        type: Array,
        default: () => [],
    },
});

function viewVoucher(id) {
    window.location.href = route("vouchers.show", id);
}

function formatDate(date) {
    if (!date) {
        return "-";
    }

    return new Date(date).toLocaleString("id-ID");
}
</script>

<template>
    <Head title="Vouchers" />

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold">Vouchers</h1>

            <p class="mt-1 text-gray-500">View generated customer vouchers.</p>
        </div>

        <Card>
            <template #content>
                <DataTable
                    :value="props.vouchers"
                    paginator
                    :rows="10"
                    stripedRows
                    responsiveLayout="scroll"
                    dataKey="id"
                >
                    <Column header="Voucher Code">
                        <template #body="{ data }">
                            {{ data.code }}
                        </template>
                    </Column>

                    <Column header="Customer">
                        <template #body="{ data }">
                            {{ data.reward?.customer?.name ?? "-" }}
                        </template>
                    </Column>

                    <Column header="Reward">
                        <template #body="{ data }">
                            {{
                                data.reward?.reward_configuration
                                    ?.reward_name ?? "-"
                            }}
                        </template>
                    </Column>

                    <Column header="Discount">
                        <template #body="{ data }">
                            {{ data.discount_percentage }}%
                        </template>
                    </Column>

                    <Column header="Expired At">
                        <template #body="{ data }">
                            {{ formatDate(data.expired_at) }}
                        </template>
                    </Column>

                    <Column header="Status">
                        <template #body="{ data }">
                            <Tag
                                :value="data.status"
                                :severity="
                                    data.status === 'ACTIVE'
                                        ? 'success'
                                        : data.status === 'USED'
                                          ? 'warn'
                                          : 'danger'
                                "
                            />
                        </template>
                    </Column>

                    <Column header="Action" style="width: 140px">
                        <template #body="{ data }">
                            <Button
                                label="Detail"
                                icon="pi pi-eye"
                                outlined
                                @click="viewVoucher(data.id)"
                            />
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </div>
</template>
