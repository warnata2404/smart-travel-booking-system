<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import Tag from "primevue/tag";

const page = usePage();

const user = computed(() => page.props.auth.user);

const menus = [
    {
        label: "Dashboard",
        icon: "pi pi-home",
        url: "/dashboard",
        roles: ["ADMIN", "CUSTOMER"],
    },

    {
        label: "Cities",
        icon: "pi pi-map-marker",
        url: "/cities",
        roles: ["ADMIN"],
    },

    {
        label: "Destinations",
        icon: "pi pi-map",
        url: "/destinations",
        roles: ["ADMIN"],
    },

    {
        label: "Reward Configurations",
        icon: "pi pi-gift",
        url: "/reward-configurations",
        roles: ["ADMIN"],
    },

    {
        label: "Weather Configurations",
        icon: "pi pi-cloud",
        url: "/weather-configurations",
        roles: ["ADMIN"],
    },

    {
        label: "Travel Analysis",
        icon: "pi pi-compass",
        url: "/travel-analysis",
        roles: ["CUSTOMER"],
    },

    {
        label: "Bookings",
        icon: "pi pi-calendar",
        url: "/bookings",
        roles: ["ADMIN", "CUSTOMER"],
    },

    {
        label: "Payments",
        icon: "pi pi-credit-card",
        url: "/payments",
        roles: ["ADMIN", "CUSTOMER"],
    },

    {
        label: "Trips",
        icon: "pi pi-send",
        url: "/trips",
        roles: ["ADMIN", "CUSTOMER"],
    },

    {
        label: "Rewards",
        icon: "pi pi-star",
        url: "/rewards",
        roles: ["ADMIN", "CUSTOMER"],
    },

    {
        label: "Vouchers",
        icon: "pi pi-ticket",
        url: "/vouchers",
        roles: ["ADMIN", "CUSTOMER"],
    },

    {
        label: "Profile",
        icon: "pi pi-user",
        url: "/profile",
        roles: ["ADMIN", "CUSTOMER"],
    },
];

const visibleMenus = computed(() => {
    return menus.filter((menu) => menu.roles.includes(user.value.role));
});

const isActive = (url) => {
    if (url === "/dashboard") {
        return page.url === "/dashboard";
    }

    return page.url.startsWith(url);
};
</script>

<template>
    <aside
        class="flex min-h-screen w-72 flex-col border-r border-gray-200 bg-white"
    >
        <div class="border-b border-gray-200 px-6 py-6">
            <div class="flex items-center gap-3">
                <i class="pi pi-send text-3xl text-primary"></i>

                <div>
                    <h2 class="text-lg font-bold">Smart Travel</h2>

                    <p class="text-sm text-gray-500">Booking System</p>
                </div>
            </div>

            <Tag :value="user.role" severity="contrast" class="mt-4" />
        </div>

        <nav class="flex-1 py-4">
            <Link
                v-for="menu in visibleMenus"
                :key="menu.url"
                :href="menu.url"
                class="mx-3 mb-1 flex items-center gap-3 rounded-lg px-4 py-3 transition-all"
                :class="[
                    isActive(menu.url)
                        ? 'bg-primary text-white'
                        : 'text-gray-700 hover:bg-gray-100',
                ]"
            >
                <i :class="menu.icon"></i>

                <span>
                    {{ menu.label }}
                </span>
            </Link>
        </nav>
    </aside>
</template>
