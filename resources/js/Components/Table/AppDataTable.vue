<script setup>
import DataTable from "primevue/datatable";

defineProps({
    value: {
        type: Array,
        required: true,
    },

    rows: {
        type: Number,
        default: 10,
    },

    dataKey: {
        type: String,
        default: "id",
    },

    paginator: {
        type: Boolean,
        default: true,
    },

    loading: {
        type: Boolean,
        default: false,
    },

    emptyMessage: {
        type: String,
        default: "No data available.",
    },
});
</script>

<template>
    <DataTable
        :value="value"
        :dataKey="dataKey"
        :rows="rows"
        :loading="loading"
        :paginator="paginator"
        stripedRows
        removableSort
        responsiveLayout="scroll"
        :emptyMessage="emptyMessage"
    >
        <slot />
    </DataTable>
</template>
