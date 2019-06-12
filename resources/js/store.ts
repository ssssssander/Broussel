import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        // userData: {},
        selectedDate: '',
        selectedFromTime: '',
        selectedToTime: '',
        latestChat: 0,
    },
    mutations: {
        // setUserData(state: any, data: any) {
        //     state.userData = data;
        // },
        setSelectedDate(state: any, data: any) {
            state.selectedDate = data;
        },
        setSelectedFromTime(state: any, data: any) {
            state.selectedFromTime = data;
        },
        setSelectedToTime(state: any, data: any) {
            state.selectedToTime = data;
        },
        setLatestChat(state: any, data: any) {
            state.latestChat = data;
        },
    },
    actions: {

    },
});
