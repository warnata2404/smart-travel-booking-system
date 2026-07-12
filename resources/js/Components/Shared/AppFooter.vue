<script setup>
const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="border-t border-gray-200 bg-white px-6 py-4">
        <div
            class="flex flex-col items-center justify-between gap-2 text-sm text-gray-500 md:flex-row"
        >
            <div>
                © {{ currentYear }}
                <span class="font-medium text-gray-700">
                    Smart Travel Booking System
                </span>
            </div>

            <div>
                Built with
                <span class="font-medium">Laravel 13</span>,
                <span class="font-medium">Inertia.js</span>,
                <span class="font-medium">Vue 3</span>,
                <span class="font-medium">PrimeVue 4</span>, and
                <span class="font-medium">Tailwind CSS 4</span>.
            </div>
        </div>
    </footer>
</template>
