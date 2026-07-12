<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();

const breadcrumbs = computed(() => {
    const segments = page.url.split("?")[0].split("/").filter(Boolean);

    if (segments.length === 0) {
        return [
            {
                label: "Dashboard",
                url: "/dashboard",
            },
        ];
    }

    let currentPath = "";

    return segments.map((segment) => {
        currentPath += `/${segment}`;

        return {
            label: segment
                .replace(/-/g, " ")
                .replace(/\b\w/g, (char) => char.toUpperCase()),
            url: currentPath,
        };
    });
});
</script>

<template>
    <nav
        aria-label="Breadcrumb"
        class="flex items-center gap-2 text-sm text-gray-500"
    >
        <Link href="/dashboard" class="hover:text-primary transition-colors">
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
                class="hover:text-primary transition-colors"
            >
                {{ item.label }}
            </Link>
        </template>
    </nav>
</template>
