import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './pages/Home';
import Contact from './pages/Contact';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            props: { test: 'hurrah' }
        },
        {
            path: '/contact',
            name: 'contact',
            component: Contact,
        },
    ],
});
