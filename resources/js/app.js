import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import helpers from './mixins/generalHelper.js';


import $ from 'jquery'
window.$ = window.jQuery = $

import Swal from 'sweetalert2'
window.Swal = Swal

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mixin(helpers)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
