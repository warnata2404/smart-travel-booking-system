<script setup>
import { computed, ref } from "vue";
import { Link, usePage, router } from "@inertiajs/vue3";

import Avatar from "primevue/avatar";
import Button from "primevue/button";
import Menu from "primevue/menu";

const page = usePage();

const user = computed(() => page.props.auth?.user ?? null);

const avatarLabel = computed(() => {
    return user.value?.name?.charAt(0)?.toUpperCase() ?? "?";
});

const roleLabel = computed(() => {
    return user.value?.role === "ADMIN" ? "System Administrator" : "Customer";
});

const menu = ref();

const menuItems = [
    {
        label: "Profile",
        icon: "pi pi-user",
        command: () => {
            router.visit("/profile");
        },
    },
    {
        separator: true,
    },
    {
        label: "Logout",
        icon: "pi pi-sign-out",
        command: () => {
            router.post("/logout");
        },
    },
];

const toggleMenu = (event) => {
    menu.value.toggle(event);
};
</script>

<template>
    <header
        class="flex items-center justify-between border-b border-slate-200 bg-white px-8 py-5 shadow-sm"
    >
        <!-- Page Title -->
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Smart Travel Booking System
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Travel Management Platform
            </p>
        </div>

        <!-- User -->
        <div class="flex items-center gap-4">
            <div class="hidden text-right lg:block">
                <div class="font-semibold text-slate-900">
                    {{ user?.name }}
                </div>

                <div class="text-sm text-slate-500">
                    {{ roleLabel }}
                </div>
            </div>

            <Button text rounded class="!p-1" @click="toggleMenu">
                <Avatar
                    :label="avatarLabel"
                    shape="circle"
                    size="large"
                    class="bg-primary text-white shadow-sm"
                />
            </Button>

            <Menu ref="menu" :model="menuItems" popup />
        </div>
    </header>
</template>
