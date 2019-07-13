import Vue from 'vue'
import VueRouter from 'vue-router'

import PageNotFound from '../PageNotFound'
import About from "./views/About";
import Home from './views/Home'
import Post from "./views/Post";

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
            path: '/about',
            name: 'about',
            component: About
        },

        {
            path: '/post/:slug',
            name: 'post',
            component: Post,
            props: true
        },

        {
            path: '*',
            name: '404',
            component: PageNotFound
        }
    ]
})