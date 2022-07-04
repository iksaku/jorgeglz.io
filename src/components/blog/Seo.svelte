<script context='module'>
  import { MetaTags } from 'svelte-meta-tags'
  import '$assets/app.css'
  import { page } from '$app/stores'
</script>

<script>
  export let title = undefined
  export let description = 'Hello! I have a blog! And here you can find... Well... Blog posts...'
  export let image = 'https://secure.gravatar.com/avatar/dfbbacbe4acbe45486084d472bf043fb?size=512'
  export let twitter_card = 'summary'

  title = title ? title + ' | JorgeGlz' : 'JorgeGlz'
</script>

<MetaTags
  {title}
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
