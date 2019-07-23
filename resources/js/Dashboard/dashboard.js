require('../bootstrap')

import Vue from 'vue'
import Dashboard from './Dashboard'
import router from './router'

new Vue({
    el: '#dashboard',
    router,
    render: h => h(Dashboard)
})