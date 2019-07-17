<template>
    <div v-if="posts.length < 1">
        <loading></loading>
    </div>
    <section class="md:max-w-6xl w-full mx-auto"
             v-else
    >
        <post-preview v-for="(post, index) in posts"
                      :key="index"
                      v-bind="post"
        />
    </section>
</template>

<script>
    import axios from 'axios'
    import PostPreview from '../components/PostPreview'

    export default {
        name: "Home",

        metaInfo: {
            title: 'Home',
            meta: [
                {
                    vmid: 'description',
                    name: 'description',
                    content: 'Hello! I have a blog! And here you can find... Well... Blog posts...'
                }
            ]
        },

        components: {
            'post-preview': PostPreview
        },

        data() {
            return {
                posts: []
            }
        },

        methods: {
            getData() {
                this.$Progress.start()
                axios.get('/api/v1/posts')
                    .then(response => {
                        this.posts = response.data.data
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        this.$Progress.fail()
                        console.log(error)
                    })
            }
        },

        created() {
            this.getData()
        }
    }
</script>