<template>
    <div class="flex flex-col items-center justify-center">
        <loading class="my-24" />

        <h1 class="text-2xl sm:text-3xl text-center font-bold italic">
            We're redirecting you...
        </h1>

        <p class="text-center">
            If you're not redirected, please
            <a :href="$route.meta.url" class="text-blue-700 hover:text-blue-900">
                click to continue
            </a>
            ...
        </p>
    </div>
</template>

<script>
    export default {
        name: "ExternalRouteRedirect",

        metaInfo: {
            title: 'Redirecting...',
            titleTemplate: null
        },

        beforeCreate() {
            window.location.href = this.$route.meta.url
        },

        mounted() {
            this.$router.back()
        }
    }
</script>

<style scoped>

</style>