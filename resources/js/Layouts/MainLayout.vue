<script setup>
import Sidebar from "@/Components/Shared/Sidebar.vue";
import TopNavigation from "@/Components/Shared/TopNavigation.vue";
import AppBreadcrumb from "@/Components/Shared/AppBreadcrumb.vue";
import AppFooter from "@/Components/Shared/AppFooter.vue";

import AppToast from "@/Components/Shared/AppToast.vue";
import AppConfirmDialog from "@/Components/Shared/AppConfirmDialog.vue";
</script>

<template>
    <div class="flex min-h-screen overflow-hidden bg-slate-100">
        <!-- Global Components -->
        <AppToast />
        <AppConfirmDialog />

        <!-- Sidebar -->
        <Sidebar />

        <!-- Main Content -->
        <div class="flex min-w-0 flex-1 flex-col">
            <!-- Top Navigation -->
            <TopNavigation />

            <!-- Page -->
            <main class="flex-1 overflow-y-auto">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="mx-auto w-full max-w-7xl">
                        <!-- Breadcrumb -->
                        <AppBreadcrumb class="mb-6" />

                        <!-- Page Content -->
                        <div class="min-w-0">
                            <slot />
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <AppFooter />
        </div>
    </div>
</template>
