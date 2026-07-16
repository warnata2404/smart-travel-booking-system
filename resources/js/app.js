import "../css/app.css";
import "primeicons/primeicons.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

import PrimeVue from "primevue/config";
import Aura from "@primeuix/themes/aura";

import ToastService from "primevue/toastservice";
import ConfirmationService from "primevue/confirmationservice";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,

    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),

    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props),
        });

        app.use(plugin);

        app.use(ZiggyVue);

        app.use(PrimeVue, {
            theme: {
                preset: Aura,
            },
            ripple: true,
            inputVariant: "filled",
        });

        app.use(ToastService);

        app.use(ConfirmationService);

        app.mount(el);
    },

    progress: {
        color: "#10b981",
    },
});
