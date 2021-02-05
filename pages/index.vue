<template>
  <div v-if="posts.length > 0">
    <div class="max-w-6xl mx-auto space-y-8">
      <card
        v-for="post in posts"
        :key="post.slug"
        class="divide-y divide-gray-400 dark:divide-gray-600"
      >
        <post-info :post="post" />

        <p v-if="post.excerpt" class="max-w-none prose p-4">
          {{ post.description }}
        </p>
      </card>

      <!-- TODO: Pagination -->
    </div>
  </div>
  <p
    v-else-if="posts.length <= 0"
    class="self-center text-center text-2xl italic"
  >
    No posts available right now
  </p>
  <div v-else class="self-center text-center text-2xl italic">Loading...</div>
</template>

<script>
  export default {
    async asyncData({ $content }) {
      const posts = await $content('posts').sortBy('createdAt', 'desc').fetch()

      return { posts }
    },
    head: {
      meta: [
        {
          hid: 'og:description',
          name: 'og:description',
          content:
            'Hello! I have a blog! And here you can find... Well... Blog posts...',
        },
      ],
    },
  }
</script>
