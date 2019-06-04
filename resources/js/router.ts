import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import(/* webpackChunkName: "js/chunks/home" */ '@/js/pages/Home'),
            meta: {
                auth: undefined,
            }
        },
        {
            path: '/contact',
            name: 'contact',
            component: () => import(/* webpackChunkName: "js/chunks/contact" */ '@/js/pages/Contact'),
            meta: {
                title: 'Contact',
                auth: undefined,
            },
        },
        {
            path: '/register',
            name: 'register',
            component: () => import(/* webpackChunkName: "js/chunks/register" */ '@/js/pages/auth/Register'),
            meta: {
                title: 'Registreren',
                auth: false,
            }
        },
        {
            path: '/register-buddy',
            name: 'register-buddy',
            component: () => import(/* webpackChunkName: "js/chunks/register-buddy" */ '@/js/pages/auth/RegisterBuddy'),
            meta: {
                title: 'Word wandelbuddy',
                auth: false,
            }
        },
        {
            path: '/login',
            name: 'login',
            component: () => import(/* webpackChunkName: "js/chunks/login" */ '@/js/pages/auth/Login'),
            meta: {
                title: 'Log in',
                auth: false,
            }
        },
        {
            path: '/app',
            name: 'dashboard',
            component: () => import(/* webpackChunkName: "js/chunks/dashboard" */ '@/js/pages/app/Dashboard'),
            meta: {
                title: 'App',
                auth: true,
            }
        },
        {
            path: '/app/datetime',
            name: 'datetime-select',
            component: () => import(/* webpackChunkName: "js/chunks/datetime-select" */ '@/js/pages/app/DateTimeSelect'),
            meta: {
                title: 'Kies datum & tijdstip',
                auth: true,
            }
        },
        {
            path: '/app/buddy',
            name: 'choose-buddy',
            component: () => import(/* webpackChunkName: "js/chunks/choose-buddy" */ '@/js/pages/app/ChooseBuddy'),
            meta: {
                title: 'Kies wandelbuddy',
                auth: true,
            }
        },
        {
            path: '/app/calendar',
            name: 'calendar',
            component: () => import(/* webpackChunkName: "js/chunks/calendar" */ '@/js/pages/app/Calendar'),
            meta: {
                title: 'Kalender',
                auth: true,
            }
        },
        {
            path: '/app/buddy/:id',
            name: 'buddy-detail',
            component: () => import(/* webpackChunkName: "js/chunks/buddy-detail" */ '@/js/pages/app/BuddyDetail'),
            meta: {
                title: 'Wandelbuddy',
                auth: true,
            }
        },
        {
            path: '*',
            name: 'error404',
            component: () => import(/* webpackChunkName: "js/chunks/error404" */ '@/js/pages/Error404'),
            meta: {
                title: 'Error 404',
                auth: undefined,
            }
        }
    ],
});

router.afterEach((to: any, from: any) => {
    if (to.meta.auth) {
        if (!Object.keys(store.state.userData).length) {
            (Vue.prototype as any).$http({
                url: `auth/user`,
                method: 'get'
            })
            .then((response: any) => {
                store.commit('setUserData', response.data.user_data);
            }, (error: any) => {
                Vue.prototype.$message.error('Er is iets misgegaan bij het ophalen van je gegevens');
            });
        }
    }

    document.title = to.meta.title ? to.meta.title + ' - Broussel' : 'Broussel';

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
        document.getElementsByTagName('header')[0].className = 'bg-gradient header-border';
    }
});

export default router;
