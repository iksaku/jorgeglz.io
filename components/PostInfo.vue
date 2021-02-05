<template>
  <div class="px-4 py-2 space-y-2">
    <h1 class="text-2xl font-bold">
      <nuxt-link
        :to="post.path"
        class="hocus:text-blue-500 focus:ring ring-blue-500 focus:outline-none"
      >
        {{ post.title }}
      </nuxt-link>
    </h1>

    <div class="flex items-center text-sm md:text-base font-medium space-x-8">
      <div>
        By
        <nuxt-link
          to="/about"
          class="hocus:text-blue-500 focus:ring ring-blue-500 focus:outline-none"
        >
          iksaku
        </nuxt-link>
      </div>

      <div class="flex items-center space-x-1">
        <span>📅</span>
        <time :datetime="createdAtDate.toISOString()">
          {{ createdAtForHumans }}
        </time>
      </div>
    </div>
  </div>
</template>

<script>
  import dayjs from 'dayjs'

  export default {
    props: {
      post: {
        type: Object,
        required: true,
      },
    },

    computed: {
      createdAtDate() {
        return dayjs(this.post.createdAt)
      },
      createdAtForHumans() {
        return this.createdAtDate.format('MMMM DD, YYYY')
      },
    },
  }
</script>
