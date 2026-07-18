<script setup>
import { computed } from "vue";
import Tag from "primevue/tag";

const props = defineProps({
    status: {
        type: String,
        required: true,
    },
});

const normalizedStatus = computed(() =>
    String(props.status).trim().toUpperCase(),
);

const label = computed(() => {
    return normalizedStatus.value
        .replace(/_/g, " ")
        .replace(/\b\w/g, (char) => char.toUpperCase());
});

const severity = computed(() => {
    switch (normalizedStatus.value) {
        case "ACTIVE":
        case "CONFIRMED":
        case "COMPLETED":
        case "PAID":
        case "SUCCESS":
            return "success";

        case "PENDING":
        case "PENDING_PAYMENT":
        case "ON_GOING":
        case "IN_PROGRESS":
            return "warn";

        case "USED":
            return "info";

        case "INACTIVE":
        case "FAILED":
        case "CANCELLED":
        case "EXPIRED":
            return "danger";

        default:
            return "secondary";
    }
});

const icon = computed(() => {
    switch (normalizedStatus.value) {
        case "ACTIVE":
            return "pi pi-check-circle";

        case "CONFIRMED":
            return "pi pi-verified";

        case "COMPLETED":
            return "pi pi-check";

        case "PAID":
            return "pi pi-credit-card";

        case "SUCCESS":
            return "pi pi-check-circle";

        case "PENDING":
        case "PENDING_PAYMENT":
            return "pi pi-clock";

        case "ON_GOING":
        case "IN_PROGRESS":
            return "pi pi-spin pi-spinner";

        case "USED":
            return "pi pi-ticket";

        case "FAILED":
            return "pi pi-times-circle";

        case "CANCELLED":
            return "pi pi-ban";

        case "EXPIRED":
            return "pi pi-calendar-times";

        case "INACTIVE":
            return "pi pi-minus-circle";

        default:
            return "pi pi-info-circle";
    }
});

const customClass = computed(() => {
    switch (normalizedStatus.value) {
        case "ACTIVE":
        case "CONFIRMED":
        case "COMPLETED":
        case "PAID":
        case "SUCCESS":
            return "font-semibold";

        case "PENDING":
        case "PENDING_PAYMENT":
        case "ON_GOING":
        case "IN_PROGRESS":
            return "font-semibold";

        case "USED":
            return "font-semibold";

        case "FAILED":
        case "CANCELLED":
        case "EXPIRED":
        case "INACTIVE":
            return "font-semibold";

        default:
            return "font-medium";
    }
});
</script>

<template>
    <Tag
        :value="label"
        :severity="severity"
        :icon="icon"
        :title="label"
        rounded
        class="px-3 py-1 text-xs tracking-wide"
        :class="customClass"
    />
</template>
