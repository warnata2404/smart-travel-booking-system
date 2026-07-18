<script setup>
import ConfirmDialog from "primevue/confirmdialog";
</script>

<template>
    <ConfirmDialog
        :pt="{
            root: {
                class: 'overflow-hidden rounded-2xl border border-slate-200 shadow-2xl',
            },
            header: {
                class: 'border-b border-slate-200 bg-slate-50 px-6 py-5',
            },
            title: {
                class: 'text-lg font-semibold text-slate-900',
            },
            content: {
                class: 'px-6 py-6',
            },
            message: {
                class: 'text-sm leading-6 text-slate-600',
            },
            footer: {
                class: 'flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4',
            },
            rejectButton: {
                class: 'p-button-outlined p-button-secondary',
            },
            acceptButton: {
                class: 'p-button-danger',
            },
        }"
    />
</template>
