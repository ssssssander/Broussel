import bearer from '@websanova/vue-auth/drivers/auth/bearer';
import axios from '@websanova/vue-auth/drivers/http/axios.1.x';
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x';

const config: any = {
    auth: bearer,
    http: axios,
    router: router,
    tokenDefaultName: 'broussel',
    tokenStore: ['localStorage', 'cookie'],
    rolesVar: 'role',
    authRedirect: { path: 'nl/login' },
    forbiddenRedirect: { path: '/error404' },
    notFoundRedirect: {path: '/error404'},
    registerData: {url: 'auth/register', method: 'POST', redirect: undefined},
    loginData: {url: 'auth/login', method: 'POST', redirect: undefined, fetchUser: true},
    logoutData: {url: 'auth/logout', method: 'POST', redirect: undefined, makeRequest: true},
    fetchData: {url: 'auth/user', method: 'GET', enabled: true},
    refreshData: {url: 'auth/refresh', method: 'GET', enabled: true, interval: 30},
};

export default config;
