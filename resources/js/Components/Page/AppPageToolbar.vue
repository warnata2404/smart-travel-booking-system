<script setup>
defineProps({
    justify: {
        type: String,
        default: "end",
        validator: (value) =>
            ["start", "center", "between", "end"].includes(value),
    },
});

const justifyClass = {
    start: "justify-start",
    center: "justify-center",
    between: "justify-between",
    end: "justify-end",
};
</script>

<template>
    <div
        class="flex flex-wrap items-center gap-3"
        :class="justifyClass[justify]"
    >
        <slot />
    </div>
</template>
