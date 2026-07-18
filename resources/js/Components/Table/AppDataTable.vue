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
        :emptyMessage="emptyMessage"
        :rowsPerPageOptions="[10, 20, 50, 100]"
        stripedRows
        rowHover
        removableSort
        scrollable
        scrollHeight="flex"
        responsiveLayout="scroll"
        tableStyle="min-width: 100%;"
        paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
        currentPageReportTemplate="Showing {first} - {last} of {totalRecords} records"
        class="overflow-hidden"
        :pt="{
            root: {
                class: 'overflow-hidden',
            },

            table: {
                class: 'text-sm',
            },

            thead: {
                class: 'bg-slate-50',
            },

            headerCell: {
                class: 'border-b border-slate-200 px-6 py-4 font-semibold text-slate-700',
            },

            bodyRow: {
                class: 'transition-colors duration-150',
            },

            bodyCell: {
                class: 'px-6 py-4 align-middle',
            },

            paginator: {
                class: 'border-t border-slate-200 px-6 py-4',
            },

            loadingOverlay: {
                class: 'bg-white/70 backdrop-blur-sm',
            },

            emptyMessage: {
                class: 'py-12 text-center text-slate-500',
            },
        }"
    >
        <slot />
    </DataTable>
</template>
