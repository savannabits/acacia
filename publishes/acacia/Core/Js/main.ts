import "@/bootstrap";
import PrimeVue from "primevue/config";
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from "primevue/toastservice"
import '~/css/app.css';
import '~/css/style.scss';
// import "primevue/resources/themes/tailwind-light/theme.css";
// import "primevue/resources/themes/mdc-light-indigo/theme.css";
// import "primevue/resources/themes/mdc-light-deeppurple/theme.css";
// import "primevue/resources/themes/bootstrap4-light-blue/theme.css";
// import "primevue/resources/themes/fluent-light/theme.css";
import "primevue/resources/themes/saga-purple/theme.css";
// import "primevue/resources/themes/vela-orange/theme.css";
// import "primevue/resources/themes/vela-purple/theme.css";
// import "primevue/resources/themes/saga-blue/theme.css";
// import "primevue/resources/themes/lara-light-indigo/theme.css";
// import "primevue/resources/themes/lara-light-teal/theme.css";
// import "primevue/resources/themes/lara-light-blue/theme.css";
// import "primevue/resources/themes/lara-light-purple/theme.css";
import "~/css/primevue.css";
import "primeicons/primeicons.css";
import { createApp, h } from 'vue';
import {createInertiaApp, Link} from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import route from "ziggy-js";
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const currencyFormatter = (currency='ksh') => Intl.NumberFormat('en-US',{style: 'currency',currency: currency});
const formatter = (dp) => Intl.NumberFormat('en-US',{minimumFractionDigits: dp,});
const unitFormatter = (unit='kilogram') => Intl.NumberFormat('en-US',{style: 'unit', unit: unit});
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
            .mixin({ methods: { route, currencyFormatter, unitFormatter, formatter } })
            .mount(el);
    },
} as any);

InertiaProgress.init({ color: 'rgb(34, 197, 94)' });
