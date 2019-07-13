<template>
    <section class="max-w-6xl w-full mx-auto">
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