<script setup>
import Card from "primevue/card";

defineProps({
    padded: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <Card>
        <template #content>
            <div :class="[padded ? 'space-y-6' : '']">
                <slot />
            </div>
        </template>
    </Card>
</template>
