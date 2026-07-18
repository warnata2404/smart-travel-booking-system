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

    icon: {
        type: String,
        default: "",
    },

    bordered: {
        type: Boolean,
        default: true,
    },

    compact: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <section
        :class="[
            'space-y-6',
            bordered ? 'rounded-xl border border-slate-200 bg-white' : '',
        ]"
    >
        <!-- Header -->
        <div
            :class="[
                'flex flex-col gap-4 md:flex-row md:items-start md:justify-between',
                bordered ? 'border-b border-slate-200 px-6 py-5' : '',
            ]"
        >
            <div class="flex items-start gap-3">
                <div
                    v-if="icon"
                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-100 text-primary-600"
                >
                    <i :class="[icon, 'text-lg']" />
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-900">
                        {{ title }}
                    </h2>

                    <p
                        v-if="description"
                        class="mt-1 text-sm leading-6 text-slate-500"
                    >
                        {{ description }}
                    </p>
                </div>
            </div>

            <div
                v-if="$slots.actions"
                class="flex flex-wrap items-center gap-2"
            >
                <slot name="actions" />
            </div>
        </div>

        <!-- Content -->
        <div
            :class="[
                bordered ? 'px-6 pb-6' : '',
                compact ? 'space-y-4' : 'space-y-6',
            ]"
        >
            <slot />
        </div>
    </section>
</template>
