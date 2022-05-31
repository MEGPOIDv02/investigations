window.axios = require('axios');

import Vue from 'vue';
import router from './router/router';
import App from "./pages/App";
import vuetify from "../components/vuetify/vuetify";
import VTooltip from 'v-tooltip';
import store from "./store/index";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';



export const bus = new Vue();

Vue.use(VTooltip);

Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app',
    router,
    vuetify,
    store,
    render: h => h(App)
});
