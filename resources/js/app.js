import './bootstrap';
import '../css/app.css';
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import 'primeicons/primeicons.css'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import PrimeVue from "primevue/config"
import preset from "./preset"
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue,{
                theme:{
                    preset:preset,
                    options:{
                        darkModeSelector:".dark"
                    }
                },
            })
            .use(ToastService)
            .use(ConfirmationService)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
