<template>
    <div>
        This is home... Yay!
    </div>
</template>

<script>
    export default {
        name: "Home",

        data() {
            return {
                testy: false
            }
        },

        methods: {
            shortcutHandler: function (e) {
                let ctrlKey = window.navigator.platform.match('Mac') ? e.metaKey : e.ctrlKey

                if (ctrlKey && e.code === 'KeyS') {
                    console.log('Ctrl + S!')
                }
            }
        },

        created() {
            document.addEventListener('keydown', this.shortcutHandler, false)
        },

        destroyed() {
            document.removeEventListener('keydown', this.shortcutHandler)
        }
    }
</script>