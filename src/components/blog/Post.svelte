<script context="module">
  import { format } from 'date-fns'
</script>

<script>
  export let title
  export let description
  export let url
  export let date = undefined
  export let image = undefined
  export let excerpt = undefined

  export let preview = false

  if (date) {
    date = new Date(date.replace(/Z$/, '-06:00'))
  }
</script>

<svelte:head>
  <title>{title}</title>
  <meta name='og:title' content={title}>
  <meta name='description' content={description}>
  <meta name='og:description' content={description}>
  <meta name='og:url' content={url}>
  {#if image}
    <meta name='og:image' content={image}>
  {/if}
</svelte:head>

<div
  class='w-full bg-gray-50 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg divide-y divide-gray-400 dark:divide-gray-600'
>
  <!-- Metadata -->
  <div class='px-4 py-2 space-y-2'>
    <!-- Title -->
    <h1 class='text-2xl font-semibold'>
      {#if preview}
        <a href={url} class="block hocus:text-blue-700 dark:hocus:text-blue-500 focus:ring ring-blue-500 focus:outline-none">
          {title}
        </a>
      {:else}
        {title}
      {/if}
    </h1>

    <div class='flex items-center text-gray-700 dark:text-gray-300 text-sm md:text-base font-medium space-x-8'>
      <!-- Author -->
      <a
        href='/about'
        class='flex items-center hocus:text-blue-700 dark:hocus:text-blue-500 focus:ring ring-blue-500 focus:outline-none space-x-1'
      >
        <div class='relative w-8 h-8 rounded-full overflow-hidden'>
          <img
            src='https://secure.gravatar.com/avatar/dfbbacbe4acbe45486084d472bf043fb?size=96'
            alt="Jorge González's Avatar"
          />
        </div>
        <span>Jorge González</span>
      </a>

      {#if date}
        <!-- Publish Date -->
        <div class='flex items-center space-x-1'>
          <span>📅</span>
          <time dateTime={date.toISOString()}>
            {format(date, 'MMMM do, y')}
          </time>
        </div>
      {/if}
    </div>
  </div>

  <!-- Content -->
  <article class="prose dark:prose-invert prose-lg max-w-none px-4 py-2">
    <slot>
      {#if excerpt}
        {@html excerpt}
      {/if}
    </slot>

    {#if preview}
      <a href={url} class='focus:ring ring-blue-500 focus:outline-none'>
        Continue Reading →
      </a>
    {/if}
  </article>
</div>
