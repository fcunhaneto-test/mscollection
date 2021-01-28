require('./bootstrap');

window.Vue = require('vue');

import Buefy from 'buefy'
Vue.use(Buefy, {
    defaultIconPack: 'fas',
})

import store from './store/main'

import VueRouter from "vue-router"
import router from "./routes"
Vue.use(VueRouter)

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

Vue.filter('strTime', function (value) {
    if(value) {
        let time = value.split(':')
        return time[0] + ':' + time[1]
    }
})

import Index from './Index'
import Admin from "./Admin";

const app = new Vue({
    el: '#app',
    store,
    router,
    components: {Index, Admin}
});
