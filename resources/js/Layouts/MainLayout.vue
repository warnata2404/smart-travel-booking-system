<script setup>
import Sidebar from "@/Components/Shared/Sidebar.vue";
import TopNavigation from "@/Components/Shared/TopNavigation.vue";
import AppBreadcrumb from "@/Components/Shared/AppBreadcrumb.vue";
import AppFooter from "@/Components/Shared/AppFooter.vue";

import AppToast from "@/Components/Shared/AppToast.vue";
import AppConfirmDialog from "@/Components/Shared/AppConfirmDialog.vue";
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Global Components -->
        <AppToast />

        <AppConfirmDialog />

        <!-- Sidebar -->
        <Sidebar />

        <!-- Main Content -->
        <div class="flex flex-1 flex-col min-w-0">
            <!-- Header -->
            <TopNavigation />

            <!-- Content -->
            <main class="flex-1 p-6">
                <AppBreadcrumb />

                <div class="mt-6">
                    <slot />
                </div>
            </main>

            <!-- Footer -->
            <AppFooter />
        </div>
    </div>
</template>
