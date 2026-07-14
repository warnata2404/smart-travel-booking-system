<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();

const currentUrl = computed(() => page.url);

const user = computed(() => page.props.auth.user);

const isAdmin = computed(() => user.value?.role === "ADMIN");

const isCustomer = computed(() => user.value?.role === "CUSTOMER");

const adminMenus = [
    {
        label: "Dashboard",
        icon: "pi pi-home",
        route: "/dashboard",
    },
    {
        label: "Cities",
        icon: "pi pi-map-marker",
        route: "/cities",
    },
    {
        label: "Destinations",
        icon: "pi pi-map",
        route: "/destinations",
    },
    {
        label: "Weather Configuration",
        icon: "pi pi-cloud",
        route: "/weather-configurations",
    },
    {
        label: "Reward Configuration",
        icon: "pi pi-cog",
        route: "/reward-configurations",
    },
    {
        label: "Bookings",
        icon: "pi pi-calendar-plus",
        route: "/bookings",
    },
    {
        label: "Payments",
        icon: "pi pi-credit-card",
        route: "/payments",
    },
    {
        label: "Trips",
        icon: "pi pi-map",
        route: "/trips",
    },
    {
        label: "Rewards",
        icon: "pi pi-gift",
        route: "/rewards",
    },
    {
        label: "Vouchers",
        icon: "pi pi-ticket",
        route: "/vouchers",
    },
    {
        label: "Profile",
        icon: "pi pi-user",
        route: "/profile",
    },
];

const customerMenus = [
    {
        label: "Dashboard",
        icon: "pi pi-home",
        route: "/dashboard",
    },
    {
        label: "Travel Analysis",
        icon: "pi pi-compass",
        route: "/travel-analysis",
    },
    {
        label: "Bookings",
        icon: "pi pi-calendar-plus",
        route: "/bookings",
    },
    {
        label: "Payments",
        icon: "pi pi-credit-card",
        route: "/payments",
    },
    {
        label: "Trips",
        icon: "pi pi-map",
        route: "/trips",
    },
    {
        label: "Rewards",
        icon: "pi pi-gift",
        route: "/rewards",
    },
    {
        label: "Vouchers",
        icon: "pi pi-ticket",
        route: "/vouchers",
    },
    {
        label: "Profile",
        icon: "pi pi-user",
        route: "/profile",
    },
];

const menus = computed(() => {
    if (isAdmin.value) {
        return adminMenus;
    }

    if (isCustomer.value) {
        return customerMenus;
    }

    return [];
});
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
