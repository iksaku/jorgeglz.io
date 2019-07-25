<template>
    <div class="min-h-screen h-full w-full flex flex-col">
        <navbar />

        <div class="h-full w-full flex-1">
            <div class="container mx-auto p-4">
                <keep-alive :max="5" exclude="ExternalRouteRedirect">
                    <router-view :key="$route.path" />
                </keep-alive>
            </div>
        </div>

        <Footer />

        <vue-progress-bar />
    </div>
</template>

<script>
    import Footer from './components/Footer'
    import Navbar from './components/Navbar'

    export default {
        name: "App",

        components: {
            Footer,
            'navbar': Navbar
        },

        metaInfo: {
            title: 'Jorge González',
            titleTemplate: '%s | Jorge González',
            meta: [
                {
                    vmid: 'description',
                    name: 'description',
                    content: 'Welcome to my website, I hope its interesting enough :)'
                }
            ],

            refreshOnceOnNavigation: true
        }
    }
</script>