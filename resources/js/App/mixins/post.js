import axios from 'axios'
import markdownIt from '../../plugins/markdown'

export const post = {
    props: {
        slug: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: false,
            default: undefined
        },
        content: {
            type: String,
            required: false,
            default: null
        },
        updated_at: {
            type: String,
            required: false,
            default: null
        },
        published_at: {
            required: false,
            default: null,
            validator: prop => typeof prop === 'string' || prop === null
        },
        author: {
            type: Object,
            required: false,
            default: () => ({
                name: null,
                email: null,
                avatar: null
            })
        },
        tags: {
            type: Array,
            required: false,
            default: () => []
        }
    },

    data() {
        return {
            loading: false,

            post_title: this.title,
            post_content: this.content,
            post_updated_at: this.updated_at,
            post_published_at: this.published_at,
            post_author: this.author,
            post_tags: this.tags
        }
    },

    methods: {
        md: () => markdownIt,

        getData() {
            if (!this.loading && this.post_content === null) {
                this.loading = true
                this.$Progress.start()
                axios.get(`/api/v1/posts/${this.slug}`)
                    .then(result => {
                        this.setData(result.data)
                        this.$Progress.finish()
                    })
                    .catch(error => {
                        this.$Progress.fail()
                        console.log(error.response)
                    })
                    .finally(() => {
                        this.loading = false
                        this.onDataLoad()
                    })
            }
        },

        setData(data) {
            this.post_title = data['title']
            this.post_content = data['content']
            this.post_updated_at = data['updated_at']
            this.post_published_at = data['published_at']
            this.post_author = data['author']
            this.post_tags = data['tags']
        },

        onDataLoad() {}
    },

    created() {
        this.getData()
    }
}

export default post