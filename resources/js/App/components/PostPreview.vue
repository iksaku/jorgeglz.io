<template>
    <div class="post-preview bg-gray-100 border border-gray-300 rounded shadow max-w-4xl w-full mx-auto p-4 group cursor-pointer"
         @click="goToPost"
    >
        <section>
            <h1 class="text-xl font-bold group-hover:text-blue-700">
                {{ post_title }}
            </h1>
            <publish-date :timestamp="this.post_published_at" />
        </section>
        <p class="md_content mt-2">
            <span v-html="renderedContent"></span>
            <router-link :to="routerData"
                         class="font-bold group-hover:text-blue-700"
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

        methods: {
            goToPost() {
                this.$router.push(this.routerData)
            }
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