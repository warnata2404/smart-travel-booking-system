<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";

import Card from "primevue/card";
import Divider from "primevue/divider";
import Button from "primevue/button";
import Tag from "primevue/tag";

defineOptions({
    layout: MainLayout,
});

const props = defineProps({
    voucher: {
        type: Object,
        required: true,
    },
});

function formatDate(date) {
    if (!date) {
        return "-";
    }

    return new Date(date).toLocaleString("id-ID");
}

function statusSeverity(status) {
    switch (status) {
        case "ACTIVE":
            return "success";

        case "USED":
            return "warn";

        case "EXPIRED":
            return "danger";

        default:
            return "secondary";
    }
}
</script>

<template>
    <Head title="Voucher Detail" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Voucher Detail</h1>

                <p class="mt-1 text-gray-500">Generated voucher information.</p>
            </div>

            <Button
                label="Back"
                icon="pi pi-arrow-left"
                outlined
                @click="$inertia.visit(route('vouchers.index'))"
            />
        </div>

        <Card>
            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <strong>Voucher Code</strong>

                        <div>
                            {{ voucher.code }}
                        </div>
                    </div>

                    <div>
                        <strong>Status</strong>

                        <div>
                            <Tag
                                :value="voucher.status"
                                :severity="statusSeverity(voucher.status)"
                            />
                        </div>
                    </div>

                    <div>
                        <strong>Discount</strong>

                        <div>{{ voucher.discount_percentage }}%</div>
                    </div>

                    <div>
                        <strong>Expired At</strong>

                        <div>
                            {{ formatDate(voucher.expired_at) }}
                        </div>
                    </div>
                </div>

                <Divider />

                <h3 class="text-lg font-semibold mb-4">Reward Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <strong>Customer</strong>

                        <div>
                            {{ voucher.reward?.customer?.name ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <strong>Reward</strong>

                        <div>
                            {{
                                voucher.reward?.reward_configuration
                                    ?.reward_name ?? "-"
                            }}
                        </div>
                    </div>

                    <div>
                        <strong>Total Distance</strong>

                        <div>
                            {{ voucher.reward?.total_distance ?? "-" }} km
                        </div>
                    </div>

                    <div>
                        <strong>Generated At</strong>

                        <div>
                            {{ formatDate(voucher.reward?.generated_at) }}
                        </div>
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>
