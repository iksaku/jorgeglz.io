<template>
    <layout>
        <div class="w-full md:max-w-6xl mx-auto"
             v-if="posts.data.length >= 1"
        >
            <post-preview
                v-for="post in posts.data"
                :key="post.slug"
                v-bind="post"
            />
        </div>
        <div class="h-full w-full flex items-center justify-center"
             v-else
        >
            <p class="text-center text-gray-800 text-2xl italic font-light">
                Posts are not available right now.
            </p>
        </div>
    </layout>
</template>

<script>
    import Layout from './Layout/Main'
    import PostPreview from '../../components/PostPreview'

    export default {
        name: 'Home',

        metaInfo: {
            title: 'Home | JorgeGlz',
            meta: [
                {
                    vmid: 'description',
                    name: 'description',
                    content: 'Hello! I have a blog! And here you can find... Well... Blog posts...'
                }
            ]
        },

        components: {
            Layout,
            PostPreview
        },

        props: {
            posts: Object
        }
    }
</script>
