// try {
//     window.Popper = require('popper.js').default;
// } catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueAuth from '@websanova/vue-auth'
import auth from './auth';
import router from './router';

// Don't import whole ant-design-vue package?
import { message, notification, Icon, DatePicker, TimePicker, Input } from 'ant-design-vue';
// import message from 'ant-design-vue/lib/message';
// import notification from 'ant-design-vue/lib/notification';

// Integrate css in build system?
import 'ant-design-vue/lib/message/style/index.css';
import 'ant-design-vue/lib/notification/style/index.css';
import 'ant-design-vue/lib/date-picker/style/index.css';
import 'ant-design-vue/lib/time-picker/style/index.css';
import 'ant-design-vue/lib/input/style/index.css';

// ant-design-vue
message.config({
    duration: 2,
});
Vue.use(Icon);
Vue.use(DatePicker);
Vue.use(TimePicker);
Vue.use(Input);
Vue.prototype.$message = message;
Vue.prototype.$notification = notification;

// Auth
Vue.router = router;
Vue.use(VueAxios, axios);
Vue.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;
Vue.use(VueAuth, auth);

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
let token: HTMLMetaElement | null = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    Vue.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
