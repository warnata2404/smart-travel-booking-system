<script setup>
import Message from "primevue/message";

defineProps({
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

    helper: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <div class="space-y-2">
        <label class="block font-medium text-gray-900">
            {{ label }}

            <span v-if="required" class="ml-1 text-red-500"> * </span>
        </label>

        <slot />

        <small v-if="helper && !error" class="block text-gray-500">
            {{ helper }}
        </small>

        <Message v-if="error" severity="error" size="small" variant="simple">
            {{ error }}
        </Message>
    </div>
</template>
