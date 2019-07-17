<template>
    <div v-if="!post_content">
        <loading></loading>
    </div>
    <div class="bg-gray-100 border border-gray-300 rounded shadow md:max-w-6xl p-4 h-full mx-auto"
         v-else
    >
        <div class="border-b border-gray-300 pb-2">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">
                {{ post_title }}
            </h1>
            <publish-date :timestamp="post_published_at" />
        </div>
        <article class="md_content" v-html="renderedContent"></article>
    </div>
</template>

<script>
    import PublishDate from '../components/PublishDate'
    import { post } from '../../mixins/post'

    export default {
        mixins: [post],
        name: "Post",

        metaInfo() {
            return {
                title: this.post_title || 'Loading...'
            }
        },

        components: {
            'publish-date': PublishDate
        },

        methods: {
            onDataLoad() {
                if (this.$route.hash) {
                    this.$nextTick(() => {
                        let anchor = document.querySelector(this.$route.hash)

                        // If anchor does not exist...
                        if (!anchor) {
                            return
                        }

                        window.scrollTo(0, anchor.offsetTop)
                    })
                }
            }
        },

        computed: {
            renderedContent() {
                if (this.post_content === null) return ''

                return this.md().render(this.post_content)
            }
        }
    }
</script>