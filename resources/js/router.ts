import Vue from 'vue';
import VueRouter from 'vue-router';
const Lang = require('lang.js');
const translations = require('./vue-translations.js');

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: { name: 'home', params: { locale: 'nl' }},
        },
        {
            path: '/:locale',
            component: {render (c) { return c('router-view') } },
            children: [
                {
                    path: '',
                    name: 'home',
                    component: () => import(/* webpackChunkName: "js/chunks/home" */ '@/js/pages/Home'),
                    meta: {
                        auth: undefined,
                    },
                },
                {
                    path: 'faq',
                    name: 'faq',
                    component: () => import(/* webpackChunkName: "js/chunks/faq" */ '@/js/pages/FAQ'),
                    meta: {
                        title_nl: 'FAQ',
                        title_fr: 'FAQ',
                        auth: undefined,
                    },
                },
                {
                    path: 'contact',
                    name: 'contact',
                    component: () => import(/* webpackChunkName: "js/chunks/contact" */ '@/js/pages/Contact'),
                    meta: {
                        title_nl: 'Contact',
                        title_fr: 'Contact',
                        auth: undefined,
                    },
                },
                {
                    path: '',
                    component: () => import(/* webpackChunkName: "js/chunks/auth" */ '@/js/layouts/Auth'),
                    children: [
                        {
                            path: 'register',
                            name: 'register',
                            component: () => import(/* webpackChunkName: "js/chunks/register" */ '@/js/pages/auth/Register'),
                            meta: {
                                title_nl: 'Registreren',
                                title_fr: "S'inscrire",
                                auth: false,
                            },
                        },
                        {
                            path: 'register-buddy',
                            name: 'register-buddy',
                            component: () => import(/* webpackChunkName: "js/chunks/register-buddy" */ '@/js/pages/auth/RegisterBuddy'),
                            meta: {
                                title_nl: 'Word wandelbuddy',
                                title_fr: 'Devenir un compagnon de marche',
                                auth: undefined,
                            },
                        },
                        {
                            path: 'login',
                            name: 'login',
                            component: () => import(/* webpackChunkName: "js/chunks/login" */ '@/js/pages/auth/Login'),
                            meta: {
                                title_nl: 'Log in',
                                title_fr: 'Se connecter',
                                auth: false,
                            },
                        },
                        {
                            path: 'forgot',
                            name: 'forgot-password',
                            component: () => import(/* webpackChunkName: "js/chunks/forgot-password" */ '@/js/pages/auth/ForgotPassword'),
                            meta: {
                                title_nl: 'Wachtwoord vergeten?',
                                title_fr: 'Vous avez oublié votre mot de passe?',
                                auth: false,
                            },
                        },
                        {
                            path: 'reset',
                            name: 'reset-password',
                            component: () => import(/* webpackChunkName: "js/chunks/reset-password" */ '@/js/pages/auth/ResetPassword'),
                            meta: {
                                title_nl: 'Wachtwoord resetten',
                                title_fr: 'Réinitialiser le mot de passe',
                                auth: false,
                            },
                        },
                    ],
                },
                {
                    path: 'app',
                    component: () => import(/* webpackChunkName: "js/chunks/app" */ '@/js/layouts/App'),
                    children: [
                        {
                            path: '',
                            name: 'dashboard',
                            component: () => import(/* webpackChunkName: "js/chunks/dashboard" */ '@/js/pages/app/Dashboard'),
                            meta: {
                                title_nl: 'Dashboard',
                                title_fr: 'Dashboard',
                                auth: ['user', 'buddy'],
                            },
                        },
                        {
                            path: 'find',
                            name: 'find-buddies',
                            component: () => import(/* webpackChunkName: "js/chunks/find-buddies" */ '@/js/pages/app/FindBuddies'),
                            meta: {
                                title_nl: 'Vind een wandelbuddy',
                                title_fr: 'Trouver un compagnon de marche',
                                auth: ['user'],
                            },
                        },
                        {
                            path: 'calendar',
                            name: 'calendar',
                            component: () => import(/* webpackChunkName: "js/chunks/calendar" */ '@/js/pages/app/Calendar'),
                            meta: {
                                title_nl: 'Kalender',
                                title_fr: 'Calendrier',
                                auth: ['user', 'buddy'],
                            },
                        },
                        {
                            path: 'chats',
                            name: 'chats',
                            component: () => import(/* webpackChunkName: "js/chunks/chats" */ '@/js/pages/app/Chats'),
                            meta: {
                                title_nl: 'Chats',
                                title_fr: 'Chats',
                                auth: ['user', 'buddy'],
                            },
                        },
                        {
                            path: 'settings',
                            name: 'settings',
                            component: () => import(/* webpackChunkName: "js/chunks/settings" */ '@/js/pages/app/Settings'),
                            meta: {
                                title_nl: 'Instellingen',
                                title_fr: 'Paramètres',
                                auth: true,
                            },
                        },
                        {
                            path: 'buddy/:id',
                            name: 'buddy-profile',
                            component: () => import(/* webpackChunkName: "js/chunks/buddy-profile" */ '@/js/pages/app/BuddyProfile'),
                            meta: {
                                title_nl: 'Wandelbuddy',
                                title_fr: 'Compagnon de marche',
                                auth: ['user'],
                            },
                        },
                        {
                            path: 'judge',
                            name: 'judge-buddies',
                            component: () => import(/* webpackChunkName: "js/chunks/judge-buddies" */ '@/js/pages/app/JudgeBuddies'),
                            meta: {
                                title_nl: 'Beoordelen',
                                title_fr: 'Évaluer',
                                auth: ['admin'],
                            },
                        },
                    ],
                },
                {
                    path: '*',
                    name: 'error404',
                    component: () => import(/* webpackChunkName: "js/chunks/error404" */ '@/js/pages/Error404'),
                    meta: {
                        title_nl: 'Error 404',
                        title_fr: 'Erreur 404',
                        auth: undefined,
                    },
                },
            ],
        },
    ],
});

router.beforeEach((to: any, from: any, next: any) => {
    let locales = ['nl', 'fr'];
    let locale = '';

    if (locales.indexOf(to.params.locale) > -1) {
        locale = to.params.locale;
    }
    else {
        next(false);
        return;
    }

    let lang = new Lang();
    lang.setLocale(locale);

    if (locale == 'nl') {
        lang.setFallback('fr');
    }
    if (locale == 'fr') {
        lang.setFallback('nl');
    }

    lang.setMessages(translations);
    Vue.filter('trans', (value: any, replacements: any) => {
        return lang.get(value, replacements);
    });
    Vue.prototype.$lang = lang;

    next();
});

router.afterEach((to: any, from: any) => {
    if (to.meta['title_' + Vue.prototype.$lang.getLocale()]) {
        document.title = to.meta['title_' + Vue.prototype.$lang.getLocale()] + ' - Broussel';
    }
    else {
        document.title = 'Broussel';
    }

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
