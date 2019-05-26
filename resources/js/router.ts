import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './pages/Home.vue';
import Contact from './pages/Contact.vue';
import Register from './pages/Register.vue';
import AppHome from './pages/AppHome.vue';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/contact',
            name: 'contact',
            component: Contact,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/app',
            name: 'app-home',
            component: AppHome,
        },
    ],
});
