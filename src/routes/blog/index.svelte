<script context="module" lang="ts">
  import Post from '$components/blog/Post.svelte'
  import Seo from '$components/blog/Seo.svelte'
  import { getPosts } from '$lib/posts'

  const posts = getPosts()
</script>

<Seo />

{#each posts as post (post.url)}
  <Post preview={true} {...post} />
{/each}
