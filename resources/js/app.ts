import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { InertiaProgress } from '@inertiajs/progress';
import "../css/app.css";
import axios from 'axios'

InertiaProgress.init();

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

createInertiaApp({
  resolve: name => import(`./Pages/${name}.vue`),
  setup({ el, App, props }) {
    createApp({ render: () => h(App, props) }).mount(el);
  },
});