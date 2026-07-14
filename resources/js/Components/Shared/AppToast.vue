<script setup>
import { usePage } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import Toast from "primevue/toast";
import { onMounted, watch } from "vue";

const toast = useToast();

const page = usePage();

function showFlashMessages(flash) {
    if (!flash) {
        return;
    }

    if (flash.success) {
        toast.add({
            severity: "success",
            summary: "Success",
            detail: flash.success,
            life: 3000,
        });
    }

    if (flash.error) {
        toast.add({
            severity: "error",
            summary: "Error",
            detail: flash.error,
            life: 3000,
        });
    }

    if (flash.warning) {
        toast.add({
            severity: "warn",
            summary: "Warning",
            detail: flash.warning,
            life: 3000,
        });
    }

    if (flash.info) {
        toast.add({
            severity: "info",
            summary: "Information",
            detail: flash.info,
            life: 3000,
        });
    }
}

onMounted(() => {
    showFlashMessages(page.props.flash);
});

watch(
    () => page.props.flash,
    (flash) => {
        showFlashMessages(flash);
    },
    {
        deep: true,
    },
);
</script>

<template>
    <Toast position="top-right" />
</template>
