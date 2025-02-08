import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { InertiaProgress } from '@inertiajs/progress';
import "../css/app.css";

InertiaProgress.init();

createInertiaApp({
  resolve: name => import(`./pages/${name}.vue`),
  setup({ el, App, props }) {
    createApp({ render: () => h(App, props) }).mount(el);
  },
});