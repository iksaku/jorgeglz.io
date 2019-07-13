<template>
    <div class="min-h-screen h-full w-full bg-gray-200">
        <Navbar />

        <div class="w-full">
            <div class="container mx-auto p-4">
                <keep-alive :max="5">
                    <router-view :key="$route.fullPath" />
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

        components: {
            Navbar
        }
    }
</script>