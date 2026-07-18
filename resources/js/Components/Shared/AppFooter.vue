<script setup>
const currentYear = new Date().getFullYear();

const appVersion = "v1.0.0";
</script>

<template>
    <footer class="border-t border-slate-200 bg-white">
        <div
            class="flex flex-col items-center justify-between gap-3 px-8 py-4 text-sm md:flex-row"
        >
            <!-- Copyright -->
            <div class="flex items-center gap-2 text-slate-500">
                <span>© {{ currentYear }}</span>

                <span class="font-semibold text-slate-700">
                    Smart Travel Booking System
                </span>

                <span class="hidden md:inline text-slate-300">•</span>

                <span class="hidden md:inline"> All rights reserved. </span>
            </div>

            <!-- Version -->
            <div class="flex items-center gap-2">
                <span
                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium tracking-wide text-slate-600"
                >
                    {{ appVersion }}
                </span>
            </div>
        </div>
    </footer>
</template>
