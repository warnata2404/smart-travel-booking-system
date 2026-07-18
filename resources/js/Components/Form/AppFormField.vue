<script setup>
import Message from "primevue/message";

defineProps({
    id: {
        type: String,
        default: "",
    },

    label: {
        type: String,
        required: true,
    },

    error: {
        type: String,
        default: "",
    },

    required: {
        type: Boolean,
        default: false,
    },

    optional: {
        type: Boolean,
        default: false,
    },

    helper: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <div class="space-y-2.5">
        <!-- Label -->
        <label
            v-if="label || $slots.label"
            :for="id || undefined"
            class="flex items-center gap-1 text-sm font-semibold text-slate-800"
        >
            <slot name="label">
                {{ label }}
            </slot>

            <span v-if="required" class="text-red-500" aria-hidden="true">
                *
            </span>

            <span
                v-else-if="optional"
                class="text-xs font-normal text-slate-400"
            >
                (Optional)
            </span>
        </label>

        <!-- Input -->
        <slot />

        <!-- Helper -->
        <small
            v-if="helper && !error"
            class="block text-xs leading-5 text-slate-500"
        >
            {{ helper }}
        </small>

        <!-- Validation -->
        <Message
            v-if="error"
            severity="error"
            size="small"
            variant="simple"
            class="mt-1"
        >
            {{ error }}
        </Message>
    </div>
</template>
