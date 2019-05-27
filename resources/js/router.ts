import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import(/* webpackChunkName: "js/chunks/home" */ '@/js/pages/Home.vue')
        },
        {
            path: '/contact',
            name: 'contact',
            component: () => import(/* webpackChunkName: "js/chunks/contact" */ '@/js/pages/Contact.vue')
        },
        {
            path: '/register',
            name: 'register',
            component: () => import(/* webpackChunkName: "js/chunks/register" */ '@/js/pages/Register.vue')
        },
        {
            path: '/app',
            name: 'app-home',
            component: () => import(/* webpackChunkName: "js/chunks/app-home" */ '@/js/pages/AppHome.vue')
        },
        {
            path: '/login',
            name: 'login',
            component: () => import(/* webpackChunkName: "js/chunks/login" */ './pages/Login.vue')
        },
    ],
});

router.afterEach((to: any, from: any) => {
    document.getElementsByTagName('header')[0].className = '';
    document.body.className = '';
    let whiteBackgroundPages = ['contact'];

    if (to.name == 'home') {
        document.body.className = 'bg-svg';
    }
    else if (whiteBackgroundPages.indexOf(to.name) == -1) {
        document.body.className = 'bg-gradient';
    }
    else {
        document.getElementsByTagName('header')[0].className = 'bg-gradient';
    }
});

export default router;
