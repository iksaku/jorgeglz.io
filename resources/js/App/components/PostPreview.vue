<template>
    <div class="post-preview bg-gray-100 border border-gray-300 rounded shadow max-w-6xl w-full mx-auto">
        <div class="border-b-2 border-gray-300 rounded p-4 pb-2">
            <h1 class="text-2xl font-bold">
                <router-link :to="routerData"
                             class="text-black hover:text-blue-700 focus:text-blue-700"
                >
                    {{ post_title }}
                </router-link>
            </h1>
            <post-info :author="post_author" :published="post_published_at" />
        </div>
        <section class="md_content p-4">
            <span class="inline" v-html="renderedContent.substring(0, content_length) + '...'"></span>
            <router-link :to="routerData"
                         class="font-bold inline whitespace-no-wrap"
            >
                Continue Reading
            </router-link>
        </section>
    </div>
</template>

<script>
    import PostInfo from './PostInfo'
    import mq from '../../plugins/mediaqueries'
    import post from '../mixins/post'

    export default {
        mixins: [post],
        name: "PostPreview",

        data() {
            return {
                content_length: 256
            }
        },

        components: {
            'post-info': PostInfo
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