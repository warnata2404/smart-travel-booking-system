<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();

const user = computed(() => page.props.auth?.user);
</script>

<template>
    <header
        class="flex items-center justify-between bg-white border-b border-gray-200 px-6 py-4"
    >
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                Smart Travel Booking System
            </h1>

            <p class="text-sm text-gray-500">Travel Management Platform</p>
        </div>

        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="font-medium text-gray-900">
                    {{ user?.name }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ user?.email }}
                </p>
            </div>

            <Link
                href="/profile"
                class="text-gray-600 hover:text-primary transition-colors"
            >
                <i class="pi pi-user text-xl"></i>
            </Link>

            <Link
                href="/logout"
                method="post"
                as="button"
                class="text-red-600 hover:text-red-700 transition-colors"
            >
                <i class="pi pi-sign-out text-xl"></i>
            </Link>
        </div>
    </header>
</template>
