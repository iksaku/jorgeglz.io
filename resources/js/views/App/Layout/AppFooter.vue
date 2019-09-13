<template>
    <footer class="z-40 bottom-0 inset-x-0 w-full bg-gray-200 border-t border-gray-400">
        <div class="container mx-auto px-4 flex items-center justify-between">
            <section class="font-bold text-sm sm:text-base sm:text-center py-4">
                &copy; 2019 Jorge González
            </section>
            <ul class="flex text-2xl">
                <li v-for="(data, icon) in socialLinks"
                    :key="icon"
                    class="ml-4 sm:ml-8"
                >
                    <a class="text-black"
                       :href="data.url"
                       :aria-label="`${data.name} Profile`"
                       target="_blank"
                       rel="noopener"
                    >
                        <icon :icon="['fab', icon]" />
                    </a>
                </li>
            </ul>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "AppFooter",

        data() {
            return {
                socialLinks: {
                    twitter: {
                        name: 'Twitter',
                        url: 'https://twitter.com/iksaku2'
                    },
                    github: {
                        name: 'Github',
                        url: 'https://github.com/iksaku'
                    },
                    'linkedin-in': {
                        name: 'LinkedIn',
                        url: 'https://www.linkedin.com/in/jorge-glz'
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>
