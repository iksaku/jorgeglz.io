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
            <span v-html="renderedContent"></span>
            <router-link :to="routerData"
                         class="font-bold text-blue-700 hover:text-blue-900"
            >
                More
            </router-link>
        </p>
    </div>
</template>

<script>
    import PublishDate from './PublishDate'
    import { post } from '../mixins/post'

    export default {
        mixins: [post],
        name: "PostPreview",

        components: {
            'publish-date': PublishDate
        },

        computed: {
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
            },

            renderedContent() {
                if (this.post_content === null) return ''

                return this.md().renderInline(this.post_content).substring(0, 256) + '...'
            }
        }
    }
</script>