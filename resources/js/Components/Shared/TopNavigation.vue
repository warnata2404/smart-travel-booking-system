<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

import Avatar from "primevue/avatar";
import Tag from "primevue/tag";

const page = usePage();

const user = computed(() => page.props.auth.user);

const roleLabel = computed(() => {
    return user.value?.role === "ADMIN" ? "Administrator" : "Customer";
});

const avatarLabel = computed(() => {
    return user.value?.name?.charAt(0)?.toUpperCase();
});
</script>

<template>
    <header
        class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white px-6 py-4"
    >
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                Smart Travel Booking System
            </h1>

            <p class="text-sm text-gray-500">Travel Management Platform</p>
        </div>

        <div class="flex items-center gap-4">
            <Avatar :label="avatarLabel" shape="circle" size="large" />

            <div class="hidden text-right md:block">
                <div class="font-semibold text-gray-900">
                    {{ user?.name }}
                </div>

                <Tag :value="roleLabel" severity="contrast" />
            </div>

            <Link
                href="/profile"
                class="text-gray-600 transition-colors hover:text-primary"
            >
                <i class="pi pi-user text-xl"></i>
            </Link>

            <Link
                href="/logout"
                method="post"
                as="button"
                class="text-red-600 transition-colors hover:text-red-700"
            >
                <i class="pi pi-sign-out text-xl"></i>
            </Link>
        </div>
    </header>
</template>
