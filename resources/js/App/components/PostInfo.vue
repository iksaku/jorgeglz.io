<template>
    <div class="text-gray-800 text-sm px-1">
        <section class="block sm:inline-block">
            <router-link :to="{ name: 'about' }"
                         class="inline-block align-middle hover:opacity-75 focus:opacity-75"
            >
                <img class="h-6 w-6 rounded-full"
                     :src="author.avatar" :alt="`Avatar of ${author.name}`"
                >
            </router-link>
            <router-link :to="{ name: 'about' }"
                         class="text-gray-800 hover:text-blue-700 focus:text-blue-700 inline-block align-middle ml-2"
            >
                {{ author.name }}
            </router-link>
        </section>

        <span class="hidden mx-2 sm:inline-block">|</span>

        <section class="block sm:inline-block">
            <span class="w-6 text-center font-sans inline-block align-middle mr-2 sm:mr-0">
                {{ emoji('date') }}
            </span>
            <span class="inline-block align-middle">
                <time :datetime="isoDate" v-if="published">
                    {{ formattedDate }}
                </time>
                <span class="text-red-700 italic font-bold" v-else>
                    Draft
                </span>
            </span>
        </section>
    </div>
</template>

<script>
    import dayjs from 'dayjs'
    import emoji_list from 'markdown-it-emoji/lib/data/full'

    export default {
        name: "PublishDate",

        props: {
            author: {
                type: Object,
                required: true
            },

            published: {
                required: false,
                default: null,
                validator: prop => typeof prop === 'string' || prop === null
            }
        },

        methods: {
            emoji: (name) => emoji_list[name]
        },

        computed: {
            date() {
                return dayjs(this.published)
            },

            formattedDate() {
                return this.date.format('MMMM DD, YYYY')
            },

            isoDate() {
                return this.date.toISOString()
            }
        }
    }
</script>

<style scoped>

</style>