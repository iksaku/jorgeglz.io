import axios from 'axios'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.baseURL = process.env.MIX_APP_URL

axios.interceptors.response.use(response => {
    return response
}, error => {
    if (error.response.status === 401 || error.response.status === 419) {
        window.location.href = `${process.env.MIX_APP_URL}/dashboard/login`
    }
    return Promise.reject(error)
})

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
    console.error('CSRF token not found')
}

import Vue from 'vue'

import Loading from './components/Loading'

Vue.config.productionTip = false

Vue.component('loading', Loading)

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js')

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// })
