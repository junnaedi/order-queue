import Vue from 'vue';
import Router from 'vue-router';

// define the components
import Scanner from './pages/customer/Scanner.vue';
import Order from './pages/customer/Order.vue';

import VueQrcodeReader from "vue-qrcode-reader";

Vue.use(Router);
Vue.use(VueQrcodeReader);

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/customer/scanner',
            name: 'scanner',
            component: Scanner,
        },
        {
            path: '/customer/order',
            name: 'order',
            component: Order,
        },
    ],
});

export default router;