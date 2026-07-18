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

    badge: {
        type: String,
        default: "",
    },

    icon: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <div
        class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between"
    >
        <!-- Left Section -->
        <div class="min-w-0 flex-1">
            <div v-if="badge" class="mb-3">
                <span
                    class="inline-flex items-center rounded-full bg-primary-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-primary-700"
                >
                    {{ badge }}
                </span>
            </div>

            <div class="flex items-center gap-3">
                <div
                    v-if="icon"
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100 text-primary-600"
                >
                    <i :class="[icon, 'text-xl']" />
                </div>

                <div class="min-w-0">
                    <h1
                        class="text-3xl font-bold tracking-tight text-slate-900"
                    >
                        {{ title }}
                    </h1>

                    <p
                        v-if="description"
                        class="mt-2 max-w-3xl text-sm leading-6 text-slate-500"
                    >
                        {{ description }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div v-if="$slots.actions" class="flex flex-wrap items-center gap-2">
            <slot name="actions" />
        </div>
    </div>
</template>
