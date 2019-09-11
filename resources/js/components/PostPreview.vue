<template>
    <div class="max-w-6xl w-full post-preview bg-gray-100 border border-gray-400 rounded shadow mx-auto">
        <div class="border-b-2 border-gray-300 rounded p-4 pb-2">
            <inertia-link :href="`/posts/${slug}`" class="text-black inline-block">
                <h2 class="text-2xl font-bold">
                    {{ title }}
                </h2>
            </inertia-link>
            <post-info :author="author" :published="published_at" />
        </div>
        <div class="md-content text-justify p-4">
            <span class="inline" v-html="renderedContent + '...'"></span>
            <inertia-link :href="`/posts/${slug}`" class="font-bold inline whitespace-no-wrap">
                Continue Reading
            </inertia-link>
        </div>
    </div>
</template>

<script>
    import post from './mixins/post'
    import PostInfo from './PostInfo'

    export default {
        name: "PostPreview",

        inheritAttrs: false,

        mixins: [post],

        components: {
            PostInfo
        },

        computed: {
            renderedContent() {
                if (this.content === null || this.content.length < 0) return ''

                return this.renderInline(this.content).substring(0, 256)
            }
        }
    }
</script>
