<script setup>
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Authentication" />

    <div
        class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-8"
    >
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="mb-8 text-center">
                <Link href="/">
                    <h1 class="text-3xl font-bold text-primary">
                        Smart Travel
                    </h1>

                    <p class="mt-2 text-gray-500">Booking System</p>
                </Link>
            </div>

            <!-- Card -->
            <div
                class="rounded-xl bg-white shadow-md border border-gray-200 p-8"
            >
                <slot />
            </div>
        </div>
    </div>
</template>
