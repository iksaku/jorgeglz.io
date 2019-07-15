<template>
    <div class="h-full w-full bg-gray-200 flex items-center justify-center mt-24">
        <div>
            <h1 class="text-center text-gray-900 text-6xl font-bold">
                404
            </h1>
            <p class="text-center text-gray-900 text-2xl">
                Oops... You reached <span class="italic">nowhere</span>... Please
                <a class="font-bold cursor-pointer hover:underline" @click="jumpBack()">jump back</a>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PageNotFound",

        methods: {
            jumpBack() {
                this.$router.back()
            }
        }
    }
</script>