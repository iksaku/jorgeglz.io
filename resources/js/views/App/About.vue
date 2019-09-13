<template>
    <layout>
        <div class="md:max-w-6xl bg-gray-100 border border-gray-300 rounded shadow p-4 mx-auto">
            <h1 class="text-3xl text-center font-bold mb-4">
                {{ randomIntroductoryPhrase() }}
            </h1>

            <article class="markdown" v-html="renderedContent"></article>
        </div>
    </layout>
</template>

<script>
    import emoji_list from 'markdown-it-emoji/lib/data/full'
    import markdownIt from '../../plugins/markdown-it'
    import Layout from './Layout/Main'

    import AboutContent from './components/About.md'

    export default {
        name: 'About',

        components: {
            Layout
        },

        metaInfo: {
            title: 'About',
            meta: [
                {
                    vmid: 'description',
                    name: 'description',
                    content: 'Here you can get a gist of who I am, and what do I like.'
                }
            ]
        },

        props: {
            content: String
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
                ]
            }
        },

        methods: {
            randomIntroductoryPhrase() {
                return this.phrases[Math.floor(Math.random() * this.phrases.length)]
            }
        },

        computed: {
            renderedContent() {
                if (AboutContent === null || AboutContent.length < 1)
                    return ''

                return markdownIt.render(AboutContent)
            }
        }
    }
</script>
