<script>
  import { page } from '$app/stores'

  export let href

  let classes = ['border-b-2 focus:ring ring-blue-500 focus:outline-none']

  if ($page.url.pathname === href) {
    classes.push('border-blue-500')
  } else {
    classes.push('border-transparent hover:border-blue-500')
  }
</script>

<a {href} class={classes.join(' ')}>
  <slot></slot>
</a>
