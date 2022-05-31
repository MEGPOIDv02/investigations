import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import IndexUsers from "../pages/users/IndexUsers";
import IndexAccelometer from "../pages/accelometer/IndexAccelometer";
import IndexStabilometry from "../pages/stabilometry/IndexStabilometry";
import IndexStimulation from "../pages/stimulation/IndexStimulation";
const prefix = '/admin/app';

let routes = [
    {
        path: prefix + '/users',
        component: IndexUsers,
        name: 'users'
    },
    {
        path: prefix + '/accelometer',
        component: IndexAccelometer,
        name: 'accelometer'
    },
    {
        path: prefix + '/stimulation',
        component: IndexStimulation,
        name: 'stimulation'
    },
    {
        path: prefix + '/stabilometry',
        component: IndexStabilometry,
        name: 'stabilometry'
    },
];

export default new VueRouter({
    mode: 'history',
    routes: routes
})
