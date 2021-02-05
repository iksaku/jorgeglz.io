<template>
  <div
    class="w-full min-h-screen flex flex-col bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-gray-100 divide-y divide-gray-400 dark:divide-gray-600"
  >
    <header-component />

    <section class="flex-grow flex sm:px-4 py-4">
      <Nuxt class="sm:container sm:mx-auto" />
    </section>

    <footer-component />
  </div>
</template>
