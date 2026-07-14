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
    reward: {
        type: Object,
        required: true,
    },
});

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
    <Head title="Reward Detail" />

    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold">Reward Detail</h1>

                <p class="text-gray-500">
                    Reward generated after trip completion.
                </p>
            </div>

            <Button
                label="Back"
                icon="pi pi-arrow-left"
                outlined
                @click="$inertia.visit(route('rewards.index'))"
            />
        </div>

        <Card>
            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <strong>Customer</strong>

                        <div>
                            {{ reward.customer?.name ?? "-" }}
                        </div>
                    </div>

                    <div>
                        <strong>Reward</strong>

                        <div>
                            {{
                                reward.reward_configuration?.reward_name ?? "-"
                            }}
                        </div>
                    </div>

                    <div>
                        <strong>Total Distance</strong>

                        <div>
                            {{ formatDistance(reward.total_distance) }}
                        </div>
                    </div>

                    <div>
                        <strong>Generated At</strong>

                        <div>
                            {{ formatDate(reward.generated_at) }}
                        </div>
                    </div>
                </div>

                <Divider />

                <h3 class="text-lg font-semibold mb-4">Voucher</h3>

                <template v-if="reward.voucher">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <strong>Voucher Code</strong>

                            <div>
                                {{ reward.voucher.code }}
                            </div>
                        </div>

                        <div>
                            <strong>Discount</strong>

                            <div>{{ reward.voucher.discount_percentage }}%</div>
                        </div>

                        <div>
                            <strong>Expired At</strong>

                            <div>
                                {{ formatDate(reward.voucher.expired_at) }}
                            </div>
                        </div>

                        <div>
                            <strong>Status</strong>

                            <div>
                                <Tag
                                    :value="reward.voucher.status"
                                    severity="success"
                                />
                            </div>
                        </div>
                    </div>
                </template>

                <template v-else>
                    <Tag value="Voucher Not Generated" severity="secondary" />
                </template>
            </template>
        </Card>
    </div>
</template>
