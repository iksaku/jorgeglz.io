<template>
    <header class="z-50 sticky top-0 inset-x-0 w-full bg-gray-200 border-b border-gray-500 shadow">
        <nav class="text-black container mx-auto px-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold py-2">
                <router-link :to="{ name: 'home' }"
                             class="cursor-pointer focus:outline-none focus:shadow-outline"
                >
                    Jorge's Blog
                </router-link>
            </h1>

            <ul class="flex">
                <li v-for="(page, routeName) in links"
                    :key="routeName"
                    class="ml-4"
                >
                    <router-link
                            :to="{ name: routeName }"
                            class="cursor-pointer border-b-2 border-transparent hover:border-blue-500 focus:border-blue-500 focus:outline-none focus:shadow-outline"
                            :class="$route.name === routeName ? 'font-bold border-blue-500' : ''"
                    >
                        {{ page }}
                    </router-link>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>
    export default {
        name: "Navbar",

        data() {
            return {
                links: {
                    home: 'Home',
                    about: 'About'
                }
            }
        }
    }
</script>