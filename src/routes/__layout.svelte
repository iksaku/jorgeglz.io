<script context="module">
  import '$assets/app.css'
  import { page } from '$app/stores'
  import { metadata } from '$lib/metadata'
</script>

<script>
  $: title = $metadata.title ? `${$metadata.title} | JorgeGlz` : 'JorgeGlz'
  $: description = $metadata.description ?? 'Hello! I have a blog! And here you can find... Well... Blog posts...'
  $: image = $metadata.image ?? 'https://secure.gravatar.com/avatar/dfbbacbe4acbe45486084d472bf043fb?size=512'
</script>

<svelte:head>
  <link rel="preconnect" href="https://secure.gravatar.com" />
  <link rel="dns-prefetch" href="https://secure.gravatar.com" />

  <title>{title}</title>
  <meta name='og:title' content={title}>
  <meta name='description' content={description}>
  <meta name='og:description' content={description}>
  <meta name='og:url' content={$page.url.toString()}>
  <meta name='og:image' content={image}>
</svelte:head>

<slot></slot>
