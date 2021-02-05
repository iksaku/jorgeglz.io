<template>
  <article>
    <card class="divide-y divide-gray-400 dark:divide-gray-600">
      <post-info :post="post" />

      <nuxt-content
        class="max-w-none prose p-4"
        :document="post"
      ></nuxt-content>
    </card>
  </article>
</template>

<script>
  export default {
    async asyncData({ params, $content }) {
      const post = await $content('posts', params.slug).fetch()

      return { post }
    },
  }
</script>
