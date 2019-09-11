require('./plugins/font-awesome')
require('./plugins/vue-meta')

import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'

Vue.use(InertiaApp)

const app = document.getElementById('app')

new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => import(`@/views/${name}`).then(module => module.default)
        }
    })
}).$mount(app)
