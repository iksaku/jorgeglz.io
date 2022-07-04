<script context="module" lang="ts">
  import { metadata} from '$lib/metadata'
  import { getPosts } from '$lib/posts'

  const posts = getPosts()
</script>

<script>
  import Post from '$components/blog/Post.svelte'

  $metadata = {}
</script>

{#each posts as post (post.url)}
  <Post preview={true} {...post} />
{/each}
