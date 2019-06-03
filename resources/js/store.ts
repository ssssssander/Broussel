import Vue from 'vue';
import Vuex from 'vuex';
import App from './layouts/App';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        userData: {},
    },
    mutations: {
        setUserData(state: any, data: any) {
            state.userData = data;
        },
    },
    actions: {

    },
});
