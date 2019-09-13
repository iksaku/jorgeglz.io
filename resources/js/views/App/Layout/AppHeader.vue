<template>
    <header class="z-40 top-0 inset-x-0 w-full bg-gray-200 border-b border-gray-400">
        <nav class="container mx-auto px-4 flex items-center justify-between">
            <inertia-link href="/">
                <span class="block text-black text-2xl font-bold py-2">
                    JorgeGlz
                </span>
            </inertia-link>

            <ul class="flex">
                <li class="ml-4">
                    <inertia-link
                        href="/about"
                        class="text-black border-b-2 border-transparent hover:border-blue-500 focus:border-blue-500"
                    >
                        About
                    </inertia-link>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>
    export default {
        name: "AppHeader"
    }
</script>

<style scoped>

</style>
