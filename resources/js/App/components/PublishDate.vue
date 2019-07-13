<template>
    <div class="text-sm text-gray-800 px-4">
        <span class="font-sans inline-block align-middle mr-2">{{ emoji('date') }}</span>

        <span class="inline-block align-middle">
            <time :datetime="isoDate" v-if="timestamp">
                {{ formattedDate }}
            </time>
            <span class="text-red-700 italic font-bold" v-else>
                Draft
            </span>
        </span>
    </div>
</template>

<script>
    import dayjs from 'dayjs'
    import emoji_list from 'markdown-it-emoji/lib/data/full'

    export default {
        name: "PublishDate",

        props: {
            timestamp: {
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
                return dayjs(this.timestamp)
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