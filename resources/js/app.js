import './bootstrap';
import '../css/app.css';
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import 'primeicons/primeicons.css'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';


/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faArrowLeft, faArrowRight, faArrowRightFromBracket, faBars, faBell, faCirclePlus, faHouse, faList, faMagnifyingGlass, faTrash, faUser, faXmark } from '@fortawesome/free-solid-svg-icons';
library.add(faBars,faMagnifyingGlass,faHouse,faCirclePlus,faUser,faXmark,faList,faArrowLeft,faBell,faArrowRight,faArrowRightFromBracket,faTrash)

// sweetalert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import PrimeVue from "primevue/config"
import preset from "./preset"
import ToastService from 'primevue/toastservice';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .component("fa-icon",FontAwesomeIcon)
            .use(plugin)
            .use(ZiggyVue)
            .use(VueSweetalert2)
            .use(PrimeVue,{
                theme:{
                    preset:preset,
                    options:{
                        darkModeSelector:".dark"
                    }
                },
            })
            .use(ToastService)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
