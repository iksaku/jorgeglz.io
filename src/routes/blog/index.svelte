<script context="module" lang="ts">
  import { getPosts } from '$lib/posts'

  const posts = getPosts()
</script>

<script>
  import Post from '$components/blog/Post.svelte'
</script>

{#each posts as post (post.url)}
  <Post preview={true} {...post} />
{/each}
