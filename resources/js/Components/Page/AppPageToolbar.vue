<script setup>
import { computed } from "vue";

const props = defineProps({
    justify: {
        type: String,
        default: "end",
        validator: (value) =>
            ["start", "center", "between", "end"].includes(value),
    },

    wrap: {
        type: Boolean,
        default: true,
    },

    bordered: {
        type: Boolean,
        default: false,
    },

    background: {
        type: Boolean,
        default: false,
    },
});

const justifyClass = {
    start: "justify-start",
    center: "justify-center",
    between: "justify-between",
    end: "justify-end",
};

const containerClass = computed(() => [
    "flex items-center gap-3",
    props.wrap ? "flex-wrap" : "flex-nowrap",
    justifyClass[props.justify],
    props.bordered ? "border-b border-slate-200 pb-4" : "",
    props.background
        ? "rounded-xl border border-slate-200 bg-slate-50 p-4"
        : "",
]);
</script>

<template>
    <div :class="containerClass">
        <!-- Advanced layout -->
        <template v-if="$slots.start || $slots.end">
            <div class="flex flex-1 flex-wrap items-center gap-3">
                <slot name="start" />
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <slot name="end" />
            </div>
        </template>

        <!-- Backward compatibility -->
        <template v-else>
            <slot />
        </template>
    </div>
</template>
