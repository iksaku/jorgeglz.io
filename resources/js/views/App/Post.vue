<template>

</template>

<script>
    import post from '../../components/mixins/post'

    export default {
        name: 'Post',

        mixins: [post],

        computed: {
            renderedContent() {
                if (this.content === null || this.content.length < 1)
                    return ''

                return this.md.render(this.content)
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
