<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();

const currentUrl = computed(() => page.url);

const menus = [
    {
        label: "Dashboard",
        icon: "pi pi-home",
        route: "/dashboard",
    },
    {
        label: "Booking",
        icon: "pi pi-calendar-plus",
        route: "/bookings",
    },
    {
        label: "Payment",
        icon: "pi pi-credit-card",
        route: "/payments",
    },
    {
        label: "Trip",
        icon: "pi pi-map",
        route: "/trips",
    },
    {
        label: "Reward",
        icon: "pi pi-gift",
        route: "/rewards",
    },
    {
        label: "Voucher",
        icon: "pi pi-ticket",
        route: "/vouchers",
    },
    {
        label: "Profile",
        icon: "pi pi-user",
        route: "/profile",
    },
];
</script>

<template>
    <aside
        class="w-64 min-h-screen bg-white border-r border-gray-200 flex flex-col"
    >
        <div class="px-6 py-5 border-b border-gray-200">
            <h1 class="text-xl font-bold text-primary">Smart Travel</h1>

            <p class="text-sm text-gray-500">Booking System</p>
        </div>

        <nav class="flex-1 py-4">
            <Link
                v-for="menu in menus"
                :key="menu.route"
                :href="menu.route"
                class="flex items-center gap-3 px-6 py-3 transition-colors"
                :class="
                    currentUrl.startsWith(menu.route)
                        ? 'bg-primary-50 text-primary font-semibold border-r-4 border-primary'
                        : 'text-gray-700 hover:bg-gray-100'
                "
            >
                <i :class="menu.icon"></i>

                <span>
                    {{ menu.label }}
                </span>
            </Link>
        </nav>
    </aside>
</template>
