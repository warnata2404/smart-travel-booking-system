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
                        .replace(/\b\w/g, (c) => c.toUpperCase()),
                url: currentPath,
            };
        });
});
</script>

<template>
    <nav
        v-if="breadcrumbs.length"
        aria-label="Breadcrumb"
        class="mb-6 flex items-center gap-2 text-sm text-gray-500"
    >
        <Link href="/dashboard" class="transition-colors hover:text-primary">
            Dashboard
        </Link>

        <template v-for="(item, index) in breadcrumbs" :key="item.url">
            <i class="pi pi-angle-right text-xs"></i>

            <span
                v-if="index === breadcrumbs.length - 1"
                class="font-medium text-gray-900"
            >
                {{ item.label }}
            </span>

            <Link
                v-else
                :href="item.url"
                class="transition-colors hover:text-primary"
            >
                {{ item.label }}
            </Link>
        </template>
    </nav>
</template>
