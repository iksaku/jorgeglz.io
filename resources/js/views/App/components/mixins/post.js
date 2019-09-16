import markdownIt from "../../../../plugins/markdown-it";

export default {
    props: {
        author: Object,
        slug: String,
        title: String,
        tags: Array,
        content: String,
        published_at: {
            required: false,
            default: null,
            validator: prop => typeof prop === "string" || prop === null
        },
        updated_at: String
    },

    methods: {
        render(src, env) {
            return markdownIt.render(src, env);
        },
        renderInline(src, env) {
            return markdownIt.renderInline(src, env);
        }
    }
};
