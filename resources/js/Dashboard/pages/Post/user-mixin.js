export const post = {
    props: {
        author_prop: {
            type: Object,
            required: false,
            default: () => ({
                name: null,
                email: null,
                avatar: null
            })
        }
    }
}

export default post