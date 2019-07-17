<template>
    <div class="post-preview bg-gray-100 border border-gray-300 rounded shadow max-w-6xl w-full mx-auto p-4">
        <div class="border-b border-gray-300 pb-2">
            <router-link :to="routerData">
                <h1 class="text-2xl font-bold hover:text-blue-700">
                    {{ post_title }}
                </h1>
            </router-link>
            <publish-date :timestamp="this.post_published_at" />
        </div>
        <p class="md_content mt-4">
            <span v-html="renderedContent.substring(0, content_length) + '...'"></span>
            <router-link :to="routerData"
                         class="font-bold text-blue-700 hover:text-blue-900 whitespace-no-wrap"
            >
                Continue Reading
            </router-link>
        </p>
    </div>
</template>

<script>
    import PublishDate from './PublishDate'
    import mq from '../../plugins/mediaqueries'
    import post from '../../mixins/post'

    export default {
        mixins: [post],
        name: "PostPreview",

        data() {
            return {
                content_length: 256
            }
        },

        components: {
            'publish-date': PublishDate
        },

        methods: {
            updateContentLength() {
                if (mq.isMd() || mq.isLg() || mq.isXl())
                    this.content_length = 512
                else
                    this.content_length = 256
            }
        },

        computed: {
            renderedContent() {
                if (this.post_content === null) return ''

                return this.md().renderInline(this.post_content)
            },

            routerData() {
                return {
                    name: 'post',
                    params: {
                        slug: this.slug,
                        title: this.post_title,
                        content: this.post_content,
                        updated_at: this.post_updated_at,
                        published_at: this.post_published_at,
                        author: this.post_author,
                        tags: this.post_tags
                    }
                }
            }
        },

        created() {
            this.updateContentLength()

            window.addEventListener('resize', this.updateContentLength)
        },

        destroyed() {
            window.removeEventListener('resize', this.updateContentLength)
        }
    }
</script>