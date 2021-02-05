<template>
  <header class="w-full bg-gray-100 dark:bg-gray-800">
    <nav class="container flex items-center justify-between px-4 py-2 mx-auto">
      <nuxt-link
        to="/"
        aria-label="Go to Blog's index"
        class="text-2xl font-bold focus:ring ring-blue-500 focus:outline-none rounded"
      >
        JorgeGlz
      </nuxt-link>

      <ul class="flex space-x-4">
        <nuxt-link
          to="/about"
          aria-label="Go to my About page"
          class="border-b-2 border-transparent hocus:border-blue-500"
          active-class="border-blue-500"
          exact
        >
          About
        </nuxt-link>
      </ul>
    </nav>
  </header>
</template>
