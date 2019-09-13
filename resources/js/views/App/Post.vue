<template>
    <layout>
        <div class="w-full md:max-w-6xl bg-gray-100 border border-gray-300 rounded shadow mx-auto">
            <h1 class="border-b-2 border-gray-300 rounded p-4 pb-2">
                <span class="text-black text-2xl font-bold">
                    {{ title }}
                </span>
                <post-info :author="author" :published="published_at" />
            </h1>
            <article class="markdown p-4" v-html="renderedContent"></article>
        </div>
    </layout>
</template>

<script>
    import post from './components/mixins/post'
    import Layout from './Layout/Main'
    import PostInfo from "./components/PostInfo";

    export default {
        name: 'Post',

        inheritAttrs: false,

        mixins: [post],

        components: {
            Layout,
            PostInfo
        },

        metaInfo() {
            return {
                title: this.title
            }
        },

        computed: {
            renderedContent() {
                if (this.content === null || this.content.length < 1)
                    return ''

                return this.render(this.content)
            }
        },

        mounted() {
            if (window.location.hash) {
                this.$nextTick(() => {
                    let anchor = document.querySelector(window.location.hash)

                    if (anchor !== null)
                        window.scrollTo(0, anchor.offsetTop)
                })
            }
        }
    }
</script>
