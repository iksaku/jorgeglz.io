<script>
  import NavLink from '../../components/blog/NavLink.svelte'

  import Github from '../../components/icons/Github.svelte'
  import LinkedIn from '../../components/icons/LinkedIn.svelte'
  import Twitter from '../../components/icons/Twitter.svelte'
</script>

<div class='w-full min-h-screen h-full flex flex-col'>
  <header class='w-full bg-gray-50 dark:bg-gray-800 border-b border-gray-400 dark:border-gray-600'>
    <nav class='md:container flex items-center justify-between px-4 py-2 md:mx-auto'>
      <a href='/'
         class='block hocus:text-blue-700 dark:hocus:text-blue-500 text-2xl font-semibold focus:ring ring-blue-500 focus:outline-none'>
        JorgeGlz
      </a>

      <ul class='flex items-center space-x-4'>
        <li>
          <NavLink href='/about'>About</NavLink>
        </li>
      </ul>
    </nav>
  </header>

  <div class='flex-grow md:container md:px-4 py-4 md:mx-auto'>
    <div class='max-w-6xl mx-auto space-y-4'>
      <slot></slot>
    </div>
  </div>

  <div class='w-full bg-gray-50 dark:bg-gray-800 border-t border-gray-500 dark:border-gray-600'>
    <footer class='md:container flex items-center justify-between p-4 md:mx-auto'>
      <div class='font-bold'>&copy; 2019 - 2022</div>

      <ul class='flex items-center space-x-4 sm:space-x-8'>
        <li>
          <a
            href='https://github.com/iksaku'
            target='_blank'
            rel='nofollow noopener noreferrer'
            title="Jorge's Github Profile"
          >
            <Github class='w-6 h-6' />
          </a>
        </li>
        <li>
          <a
            href='https://www.linkedin.com/in/jorge-glz'
            target='_blank'
            rel='nofollow noopener noreferrer'
            title="Jorge's LinkedIn Profile"
          >
            <LinkedIn class='w-6 h-6' />
          </a>
        </li>
        <li>
          <a
            href='https://twitter.com/iksaku2'
            target='_blank'
            rel='nofollow noopener noreferrer'
            title="Jorge's Twitter Profile"
          >
            <Twitter class='w-6 h-6' />
          </a>
        </li>
      </ul>
    </footer>
  </div>
</div>
