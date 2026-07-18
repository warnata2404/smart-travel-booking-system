<script setup>
import { onMounted, watch } from "vue";
import { usePage } from "@inertiajs/vue3";

import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";

const toast = useToast();
const page = usePage();

const displayedMessages = new Set();

function addToast(severity, summary, detail, icon) {
    if (!detail) {
        return;
    }

    const key = `${severity}:${detail}`;

    if (displayedMessages.has(key)) {
        return;
    }

    displayedMessages.add(key);

    toast.add({
        group: "app",
        severity,
        summary,
        detail,
        life: 4000,
        closable: true,
        icon,
    });

    setTimeout(() => {
        displayedMessages.delete(key);
    }, 4500);
}

function showFlashMessages(flash) {
    if (!flash) {
        return;
    }

    addToast("success", "Success", flash.success, "pi pi-check-circle");

    addToast("error", "Error", flash.error, "pi pi-times-circle");

    addToast("warn", "Warning", flash.warning, "pi pi-exclamation-triangle");

    addToast("info", "Information", flash.info, "pi pi-info-circle");
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
    <Toast
        group="app"
        position="top-right"
        :pt="{
            root: {
                class: 'mt-4',
            },
            message: {
                class: 'overflow-hidden rounded-xl border border-slate-200 shadow-xl',
            },
            content: {
                class: 'px-4 py-4',
            },
            summary: {
                class: 'font-semibold text-slate-900',
            },
            detail: {
                class: 'mt-1 text-sm leading-5 text-slate-600',
            },
            closeButton: {
                class: 'text-slate-500 hover:text-slate-700',
            },
        }"
    />
</template>
