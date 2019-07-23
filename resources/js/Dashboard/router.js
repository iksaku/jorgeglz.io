import Vue from 'vue'
import Router from 'vue-router'

import Home from './pages/Home'
import PageNotFound from "../components/PageNotFound";

import PostIndex from "./pages/Post/PostIndex";
import PostList from "./pages/Post/PostList";
import PostCreate from "./pages/Post/PostCreate";
import PostUpdate from "./pages/Post/Update";
import PostDetail from "./pages/Post/PostDetail";


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
            path: '/posts',
            component: PostIndex,
            children: [
                {
                    path: '',
                    name: 'post-list',
                    component: PostList
                },
                {
                    path: '/create',
                    name: 'create-post',
                    component: PostCreate
                },
                {
                    path: '/update/:post',
                    name: 'update-post',
                    component: PostUpdate,
                    props: true
                },
                {
                    path: '/:post',
                    name: 'post-detail',
                    component: PostDetail,
                    props: true
                }
            ]
        },

        {
            path: '*',
            name: '404',
            component: PageNotFound
        }
    ]
})