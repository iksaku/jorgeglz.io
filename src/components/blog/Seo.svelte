<script context='module'>
  import { MetaTags } from 'svelte-meta-tags'
  import '$assets/app.css'
  import { page } from '$app/stores'
</script>

<script>
  export let title
  export let description = 'Hello! I have a blog! And here you can find... Well... Blog posts...'
  export let image = 'https://secure.gravatar.com/avatar/dfbbacbe4acbe45486084d472bf043fb?size=512'
  export let twitter_card = 'summary'
</script>

<MetaTags
  {title}
  titleTemplate='%s | JorgeGlz'
  {description}
  openGraph={{
    url: $page.url.toString(),
    images: [
      {
        url: new URL(image, $page.url.origin).toString()
      }
    ]
  }}
  twitter={{
    site: '@iksaku2',
    handle: '@iksaku2',
    cardType: twitter_card
  }}
/>

<!--<svelte:head>
  <title>{title}</title>
  <meta name='og:title' content={title}>
  <meta name='description' content={description}>
  <meta name='og:description' content={description}>
  <meta name='og:url' content={$page.url.toString()}>
  <meta name='og:image' content={image}>
  <meta name='twitter:card' content={twitter_card}>
  <meta name='twitter:site' content='@iksaku2'>
  <meta name='twitter:creator' content='@iksaku2'>
</svelte:head>-->
