import bearer from '@websanova/vue-auth/drivers/auth/bearer';
import axios from '@websanova/vue-auth/drivers/http/axios.1.x';
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x';

const config: any = {
    auth: bearer,
    http: axios,
    router: router,
    tokenDefaultName: 'broussel',
    tokenStore: ['localStorage', 'cookie'],
    rolesVar: 'is_buddy',
    authRedirect: { path: '/login' },
    forbiddenRedirect: { path: '/' },
    notFoundRedirect: {path: '/'},
    registerData: {url: 'auth/register', method: 'POST', redirect: undefined},
    loginData: {url: 'auth/login', method: 'POST', redirect: '/app', fetchUser: true},
    logoutData: {url: 'auth/logout', method: 'POST', redirect: '/', makeRequest: true},
    fetchData: {url: 'auth/user', method: 'GET', enabled: true},
    refreshData: {url: 'auth/refresh', method: 'GET', enabled: true, interval: false},
};

export default config;
