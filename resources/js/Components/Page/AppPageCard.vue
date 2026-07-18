<script setup>
import Card from "primevue/card";

defineProps({
    title: {
        type: String,
        default: "",
    },

    subtitle: {
        type: String,
        default: "",
    },

    padded: {
        type: Boolean,
        default: true,
    },

    shadow: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <Card
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white"
        :class="shadow ? 'shadow-sm' : ''"
        :pt="{
            root: {
                class: 'overflow-hidden rounded-2xl',
            },
            body: {
                class: 'p-0',
            },
            content: {
                class: 'p-0',
            },
        }"
    >
        <!-- Header -->
        <template
            v-if="title || subtitle || $slots.header || $slots.actions"
            #header
        >
            <div
                class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 md:flex-row md:items-center md:justify-between"
            >
                <div class="min-w-0 flex-1">
                    <slot name="header">
                        <h2
                            v-if="title"
                            class="text-lg font-semibold text-slate-900"
                        >
                            {{ title }}
                        </h2>

                        <p
                            v-if="subtitle"
                            class="mt-1 text-sm leading-6 text-slate-500"
                        >
                            {{ subtitle }}
                        </p>
                    </slot>
                </div>

                <div
                    v-if="$slots.actions"
                    class="flex shrink-0 items-center gap-2"
                >
                    <slot name="actions" />
                </div>
            </div>
        </template>

        <!-- Content -->
        <template #content>
            <div :class="[padded ? 'p-6' : '', padded ? 'space-y-6' : '']">
                <slot />
            </div>
        </template>
    </Card>
</template>
