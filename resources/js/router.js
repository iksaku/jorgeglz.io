import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './views/Home'
import PageNotFound from './views/PageNotFound'

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },

        {
            path: '*',
            component: PageNotFound
        }
    ]
})