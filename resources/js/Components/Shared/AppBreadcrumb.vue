<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();

const labelMap = {
    dashboard: "Dashboard",

    cities: "Cities",
    destinations: "Destinations",

    "reward-configurations": "Reward Configurations",
    "weather-configurations": "Weather Configurations",

    "travel-analysis": "Travel Analysis",

    bookings: "Bookings",
    payments: "Payments",
    trips: "Trips",
    rewards: "Rewards",
    vouchers: "Vouchers",

    create: "Create",
    edit: "Edit",
};

const breadcrumbs = computed(() => {
    const segments = page.url.split("?")[0].split("/").filter(Boolean);

    if (
        segments.length === 0 ||
        (segments.length === 1 && segments[0] === "dashboard")
    ) {
        return [];
    }

    let currentPath = "";

    return segments
        .filter((segment) => !/^\d+$/.test(segment))
        .map((segment) => {
            currentPath += `/${segment}`;

            return {
                label:
                    labelMap[segment] ??
                    segment
                        .replace(/-/g, " ")
                        .replace(/\b\w/g, (char) => char.toUpperCase()),
                url: currentPath,
            };
        });
});
</script>

<template>
    <nav v-if="breadcrumbs.length" aria-label="Breadcrumb" class="mb-6">
        <div
            class="flex flex-wrap items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 shadow-sm"
        >
            <!-- Dashboard -->
            <Link
                href="/dashboard"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition-colors duration-200 hover:text-primary"
            >
                <i class="pi pi-home text-sm"></i>

                <span>Dashboard</span>
            </Link>

            <template v-for="(item, index) in breadcrumbs" :key="item.url">
                <i class="pi pi-angle-right text-xs text-slate-400"></i>

                <!-- Current Page -->
                <span
                    v-if="index === breadcrumbs.length - 1"
                    class="text-sm font-semibold text-slate-900"
                >
                    {{ item.label }}
                </span>

                <!-- Parent -->
                <Link
                    v-else
                    :href="item.url"
                    class="text-sm font-medium text-slate-500 transition-colors duration-200 hover:text-primary"
                >
                    {{ item.label }}
                </Link>
            </template>
        </div>
    </nav>
</template>
