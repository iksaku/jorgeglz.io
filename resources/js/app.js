require('./bootstrap');

import Vue from 'vue'
import router from './router'

Vue.productionTips = false

new Vue({
    el: '#app',
    router
});
