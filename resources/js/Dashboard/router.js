import Vue from 'vue'
import Router from 'vue-router'

import Home from './pages/Home'
import PageNotFound from "../components/PageNotFound";

Vue.use(Router)

export default new Router({
    base: '/dashboard',
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },

        {
            path: '*',
            name: '404',
            component: PageNotFound
        }
    ]
})