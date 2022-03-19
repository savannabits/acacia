import "@/bootstrap";
import PrimeVue from "primevue/config";
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from "primevue/toastservice"
import '~/css/app.css';
import '~/css/style.scss';
// import "primevue/resources/themes/tailwind-light/theme.css";
import "primevue/resources/themes/mdc-light-indigo/theme.css";
// import "primevue/resources/themes/fluent-light/theme.css";
// import "primevue/resources/themes/saga-purple/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import { createApp, h } from 'vue';
import {createInertiaApp, Link} from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import route from "ziggy-js";
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async name => {
        // @ts-ignore
        const pages = import.meta.glob('./../../**/*.vue'); // the /acacia folder
        return (await pages[`./../../${name}.vue`]()).default;
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(PrimeVue)
            .use(ConfirmationService)
            .use(ToastService)
            .component('router-link', Link)
            .mixin({ methods: { route } })
            .mount(el);
    },
} as any);

InertiaProgress.init({ color: 'rgb(34, 197, 94)' });
