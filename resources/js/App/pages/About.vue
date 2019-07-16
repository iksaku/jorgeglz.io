<template>
    <div class="bg-gray-100 border border-gray-300 rounded shadow md:max-w-6xl h-full p-4 mx-auto">
        <h1 class="text-3xl text-center font-bold">
            {{ randomIntroductoryPhrase() }}
        </h1>
    </div>
</template>

<script>
    import emoji_list from 'markdown-it-emoji/lib/data/full'

    export default {
        name: "About",

        metaInfo: {
            title: 'About'
        },

        data() {
            return {
                phrases: [
                    'Still don\'t know me?',
                    'Haven\'t we already met?',
                    'So, you want to know more about me...',
                    'Let\'s know each other!',
                    'This is me... ' + emoji_list['notes'],
                    'What? Who am I you ask?',
                    'Peeking at my blog without knowing me?',
                    '¿Sabías que también hablo Español? ' + emoji_list['mexico']

            }
        },

        methods: {
            randomIntroductoryPhrase() {
                return this.phrases[Math.floor(Math.random() * this.phrases.length)]
            }
        }
    }
</script>