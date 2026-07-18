<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();

const user = computed(() => page.props.auth?.user ?? null);

const menuGroups = Object.freeze([
    {
        title: "General",
        roles: ["ADMIN", "CUSTOMER"],
        items: [
            {
                label: "Dashboard",
                icon: "pi pi-home",
                url: "/dashboard",
                roles: ["ADMIN", "CUSTOMER"],
            },
        ],
    },

    {
        title: "Master Data",
        roles: ["ADMIN"],
        items: [
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
                label: "Travel Routes",
                icon: "pi pi-directions",
                url: "/travel-routes",
                roles: ["ADMIN"],
            },
        ],
    },

    {
        title: "Configuration",
        roles: ["ADMIN"],
        items: [
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
        ],
    },

    {
        title: "Transaction",
        roles: ["ADMIN", "CUSTOMER"],
        items: [
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
        ],
    },

    {
        title: "Account",
        roles: ["ADMIN", "CUSTOMER"],
        items: [
            {
                label: "Profile",
                icon: "pi pi-user",
                url: "/profile",
                roles: ["ADMIN", "CUSTOMER"],
            },
        ],
    },
]);

const visibleGroups = computed(() => {
    if (!user.value) {
        return [];
    }

    return menuGroups
        .map((group) => ({
            ...group,
            items: group.items.filter((item) =>
                item.roles.includes(user.value.role),
            ),
        }))
        .filter((group) => group.items.length > 0);
});

const isActive = (url) => {
    const currentUrl = page.url;

    if (url === "/dashboard") {
        return currentUrl === "/dashboard";
    }

    return currentUrl.startsWith(url);
};
</script>

<template>
    <aside
        class="flex min-h-screen w-80 flex-col border-r border-slate-200 bg-white shadow-sm"
    >
        <!-- Logo -->
        <div class="border-b border-slate-200 px-7 py-7">
            <div class="flex items-center gap-4">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10"
                >
                    <i class="pi pi-send text-2xl text-primary"></i>
                </div>

                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">
                        Smart Travel
                    </h1>

                    <p
                        class="text-xs font-medium uppercase tracking-[0.25em] text-slate-500"
                    >
                        Booking System
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-4 py-6">
            <div v-for="group in visibleGroups" :key="group.title" class="mb-7">
                <div
                    class="mb-3 px-3 text-xs font-semibold uppercase tracking-[0.2em] text-slate-400"
                >
                    {{ group.title }}
                </div>

                <Link
                    v-for="menu in group.items"
                    :key="menu.url"
                    :href="menu.url"
                    class="group mb-1 flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all duration-200"
                    :class="
                        isActive(menu.url)
                            ? 'bg-primary text-white shadow-sm'
                            : 'text-slate-700 hover:translate-x-1 hover:bg-slate-100'
                    "
                >
                    <i
                        :class="[
                            menu.icon,
                            'text-base',
                            isActive(menu.url)
                                ? 'text-white'
                                : 'text-slate-500 group-hover:text-primary',
                        ]"
                    ></i>

                    <span class="truncate">
                        {{ menu.label }}
                    </span>
                </Link>
            </div>
        </nav>
    </aside>
</template>
