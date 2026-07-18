<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import Button from "primevue/button";

const props = defineProps({
    cancelRoute: {
        type: String,
        default: null,
    },

    cancelLabel: {
        type: String,
        default: "Cancel",
    },

    cancelIcon: {
        type: String,
        default: "pi pi-times",
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

    submitDisabled: {
        type: Boolean,
        default: false,
    },

    submitSeverity: {
        type: String,
        default: "success",
    },

    align: {
        type: String,
        default: "end",
        validator: (value) =>
            ["start", "center", "between", "end"].includes(value),
    },

    separator: {
        type: Boolean,
        default: false,
    },
});

const alignmentClass = computed(() => {
    switch (props.align) {
        case "start":
            return "justify-start";

        case "center":
            return "justify-center";

        case "between":
            return "justify-between";

        default:
            return "justify-end";
    }
});

const containerClass = computed(() => [
    "mt-8",
    props.separator ? "border-t border-slate-200 pt-6" : "",
]);
</script>

<template>
    <div :class="containerClass">
        <div class="flex flex-wrap items-center gap-3" :class="alignmentClass">
            <template v-if="$slots.default">
                <slot />
            </template>

            <template v-else>
                <Link v-if="cancelRoute" :href="cancelRoute">
                    <Button
                        type="button"
                        :label="cancelLabel"
                        :icon="cancelIcon"
                        severity="secondary"
                        outlined
                        class="min-w-28"
                    />
                </Link>

                <Button
                    type="submit"
                    :label="submitLabel"
                    :icon="submitIcon"
                    :loading="loading"
                    :disabled="submitDisabled"
                    :severity="submitSeverity"
                    class="min-w-32"
                />
            </template>
        </div>
    </div>
</template>
