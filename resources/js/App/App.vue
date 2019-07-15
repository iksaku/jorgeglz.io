<template>
    <div class="min-h-screen h-full w-full">
        <Navbar />

        <div class="h-full w-full">
            <div class="container mx-auto p-4">
                <keep-alive :max="5">
                    <router-view :key="$route.path" />
                </keep-alive>
            </div>
        </div>

        <vue-progress-bar />
    </div>
</template>

<script>
    import Navbar from './components/Navbar'

    export default {
        name: "App",

        metaInfo: {
            title: 'Jorge González',
            titleTemplate: '%s | Jorge González',

            refreshOnceOnNavigation: true
        },

        components: {
            Navbar
        }
    }
</script>