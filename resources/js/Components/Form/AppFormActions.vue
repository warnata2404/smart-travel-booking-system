<script setup>
import { Link } from "@inertiajs/vue3";
import Button from "primevue/button";

defineProps({
    cancelRoute: {
        type: String,
        required: true,
    },

    cancelLabel: {
        type: String,
        default: "Cancel",
    },

    submitLabel: {
        type: String,
        default: "Save",
    },

    submitIcon: {
        type: String,
        default: "pi pi-save",
    },

    loading: {
        type: Boolean,
        default: false,
    },

    submitSeverity: {
        type: String,
        default: "success",
    },
});
</script>

<template>
    <div class="flex justify-end gap-3 pt-2">
        <Link :href="cancelRoute">
            <Button
                type="button"
                :label="cancelLabel"
                severity="secondary"
                outlined
            />
        </Link>

        <Button
            type="submit"
            :label="submitLabel"
            :icon="submitIcon"
            :loading="loading"
            :severity="submitSeverity"
        />
    </div>
</template>
