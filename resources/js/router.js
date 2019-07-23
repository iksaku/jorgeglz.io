import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'

import PageNotFound from './components/PageNotFound'

import About from "./pages/About"
import Home from './pages/Home'
import Uses from './pages/Uses'

import Post from "./views/Post"
import Tags from "./pages/Tags";
import Tag from "./views/Tag";

Vue.use(Router)
Vue.use(Meta)

export default new Router({
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
            path: '/uses',
            name: 'uses',
            component: Uses
        },

        {
            path: '/posts/:slug',
            name: 'post',
            component: Post,
            props: true
        },

        {
            path: '/tags',
            name: 'tagList',
            component: Tags,
        },

        {
            path: '/tag/:name',
            name: 'tag',
            component: Tag,
            props: true
        },

        {
            path: '*',
            name: '404',
            component: PageNotFound
        }
    ]
})