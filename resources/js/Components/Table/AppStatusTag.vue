<script setup>
import { computed } from "vue";
import Tag from "primevue/tag";

const props = defineProps({
    status: {
        type: String,
        required: true,
    },
});

const severity = computed(() => {
    switch (props.status) {
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

        case "INACTIVE":
        case "FAILED":
        case "CANCELLED":
        case "EXPIRED":
            return "danger";

        case "USED":
            return "info";

        default:
            return "secondary";
    }
});

const label = computed(() => {
    return props.status
        .replace(/_/g, " ")
        .replace(/\b\w/g, (char) => char.toUpperCase());
});
</script>

<template>
    <Tag :value="label" :severity="severity" rounded />
</template>
