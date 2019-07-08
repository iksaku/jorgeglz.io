<template>
    <div>Full post goes here...</div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "Post",

        props: {
            slug: {
                type: String,
                required: true
            },
            postData: {
                type: Object,
                default: null,
                required: false
            }
        },

        data() {
            return {
                loading: false
            }
        },

        methods: {
            getPostData() {
                this.loading = true
                axios.get(`/api/v1/posts/${this.slug}`)
                    .then(response => {
                        this.postData = response.data
                        // TODO: Markdown stuff
                        // TODO: If post not yet published, show 'draft' warning
                    })
                    .catch(error => {
                        console.log(error.response)
                    })
                    .finally(() => {
                        this.loading = false
                    })
            }
        },

        created() {
            if (this.postData === null) {
                this.getPostData()
            }
        },

        watch: {
            $route: () => {
                // TODO: Check for route change between posts
                this.getPostData()
            }
        }
    }
</script>