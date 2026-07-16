<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },

    description: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <section class="space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">
                {{ title }}
            </h2>

            <p v-if="description" class="mt-1 text-sm text-gray-500">
                {{ description }}
            </p>
        </div>

        <div class="space-y-5">
            <slot />
        </div>
    </section>
</template>
