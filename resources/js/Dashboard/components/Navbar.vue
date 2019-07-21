<template>
    <header class="z-40 top-0 inset-x-0 w-full bg-gray-200 border-b border-gray-500 shadow">
        <nav class="text-black container mx-auto px-8 flex items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-bold py-2">
                <router-link :to="{ name: 'home' }"
                             class="text-black"
                >
                    Dashboard
                </router-link>
            </h1>

            <ul class="flex">
                <li class="ml-4">
                    <button
                            class="text-white font-bold px-4 py-2 rounded bg-red-500 hover:border-red-700 focus:bg-red-700 focus:outline-none focus:shadow-outline"
                            :class="{'opacity-50': loading}"
                            :disabled="loading"
                            @click="logout"
                    >
                        Logout
                    </button>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "Navbar",

        data() {
            return {
                loading: false
            }
        },

        methods: {
            logout() {
                this.loading = true
                axios.post('/dashboard/logout')
                    .then(response => {
                        console.log(response)
                    })
                    .catch(error => {
                        if (error.response.status !== 401) {
                            console.log(error.response)
                        }
                    })
                    .finally(() => {
                        this.loading = false
                    })
            }
        }
    }
</script>