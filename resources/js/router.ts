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
            path: '/faq',
            name: 'faq',
            component: () => import(/* webpackChunkName: "js/chunks/faq" */ '@/js/pages/FAQ'),
            meta: {
                title: 'FAQ',
                auth: undefined,
            },
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
                auth: undefined,
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
            component: () => import(/* webpackChunkName: "js/chunks/app" */ '@/js/layouts/App'),
            children: [
                {
                    path: '',
                    name: 'dashboard',
                    component: () => import(/* webpackChunkName: "js/chunks/dashboard" */ '@/js/pages/app/Dashboard'),
                    meta: {
                        title: 'Dashboard',
                        auth: true,
                    }
                },
                {
                    path: 'find',
                    name: 'find-buddies',
                    component: () => import(/* webpackChunkName: "js/chunks/find-buddies" */ '@/js/pages/app/FindBuddies'),
                    meta: {
                        title: 'Vind een wandelbuddy',
                        auth: true,
                    }
                },
                {
                    path: 'calendar',
                    name: 'calendar',
                    component: () => import(/* webpackChunkName: "js/chunks/calendar" */ '@/js/pages/app/Calendar'),
                    meta: {
                        title: 'Kalender',
                        auth: true,
                    }
                },
                {
                    path: 'walks',
                    name: 'walks',
                    component: () => import(/* webpackChunkName: "js/chunks/walks" */ '@/js/pages/app/Walks'),
                    meta: {
                        title: 'Mijn wandelingen',
                        auth: true,
                    }
                },
                {
                    path: 'chats',
                    name: 'chats',
                    component: () => import(/* webpackChunkName: "js/chunks/chats" */ '@/js/pages/app/Chats'),
                    meta: {
                        title: 'Chats',
                        auth: true,
                    }
                },
                {
                    path: 'settings',
                    name: 'settings',
                    component: () => import(/* webpackChunkName: "js/chunks/settings" */ '@/js/pages/app/Settings'),
                    meta: {
                        title: 'Instellingen',
                        auth: true,
                    }
                },
                {
                    path: 'buddy/:id',
                    name: 'buddy-profile',
                    component: () => import(/* webpackChunkName: "js/chunks/buddy-profile" */ '@/js/pages/app/BuddyProfile'),
                    meta: {
                        title: 'Wandelbuddy',
                        auth: true,
                    }
                },
            ]
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

// router.beforeEach((to: any, from: any, next: any) => {
//     if (to.name == 'choose-buddy') {
//         if (from.name == 'datetime-select') {
//             next();
//         }
//         else {
//             next({ name: 'home' });
//         }
//     }
//     else {
//         next();
//     }
// });

router.afterEach((to: any, from: any) => {
    // if (to.meta.auth) {
    //     if (!Object.keys(store.state.userData).length) {
    //         (Vue.prototype as any).$http({
    //             url: `auth/user`,
    //             method: 'get'
    //         })
    //         .then((response: any) => {
    //             store.commit('setUserData', response.data.user_data);
    //         }, (error: any) => {
    //             Vue.prototype.$message.error('Er is iets misgegaan bij het ophalen van je gegevens');
    //         });
    //     }
    // }

    document.title = to.meta.title ? to.meta.title + ' - Broussel' : 'Broussel';

    document.getElementsByTagName('header')[0].className = '';
    document.body.className = '';
    let whiteBackgroundPages = ['contact', 'faq'];

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
