---
layout: '../_layout.astro'
title: 'Implementing Dark color scheme with TailwindCSS'
description: 'Dark mode has been a hot topic in the UX land for quite some time, and it recently blew up with its official implementation in major Operating Systems during the last few months...'
date: '2020-04-20'
---

Dark mode 🌑 has been a hot topic in the UX land for quite some time,
and it recently blew up with its official implementation in major Operating
Systems during the last few months.

<!-- more -->

With this trend, many websites started to generate a Dark mode version of
themselves, which may enabled manually by the user, automatically based on your
device's preference, or both ways.

> ## Important Update
>
> As of [TailwindCSS v2.0](https://blog.tailwindcss.com/tailwindcss-v2), Dark
> mode support is now provided out of the box!
>
> It provides way more customization than the method noted below, and also,
> having it supported by the library itself will remove the need for you to keep
> repeating a manual method over and over for each of the projects you manage.
>
> To learn more about the new support, please head to the new
> [Dark Mode Documentation](https://tailwindcss.com/docs/dark-mode).

## Original Post

Modern web browsers implemented this functionality recently with the
introduction of the
[`prefers-color-scheme` CSS Media Query](https://caniuse.com/#feat=prefers-color-scheme).
We can use this feature to dynamically adjust the look of our websites to match
users preferred setting 😯.

In this post I'll explain how to achieve _automatic adjustment_ based on the
`prefers-color-scheme` media query with [TailwindCSS](https://tailwindcss.com/)
⭐. If you would like to implement a manual-based switch, this is not for
you 😢.

## TailwindCSS and its Utility-first Design

TailwindCSS allows the developer to use _utility classes_ to define the look and
feel of their websites, instead of needing to create complex CSS classes for
your components ⚡. Also, it allows us to customize the configuration even
further, by changing the default color palette, screen breakpoints, interactive
variants, and way more! ✨

## Implementing the `prefers-color-scheme` Media Query

We _don't_ need to re-write all class utilities offered by Tailwind in order for
them to switch between Dark/Light modes 😬, instead, we can use media
queries to define our new color scheme _the Tailwind way_ 🔥.

All we need to do is extend the responsive configuration in our
`tailwind.config.js` file like this:

```js
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      screens: {
        dark: {
          raw: '(prefers-color-scheme: dark)'
        }
      }
    }
  }
}
```

This will add a `dark` responsive utility that works like any size utilities
like `sm`, `md`, etc. This new responsive utility will come in handy when
defining (for example) which colors to use when a user's color preference is set
to `dark`.

A simple example will be to define a White background by default, and switch to
a Darker one if possible. With our new responsive variant we could do something
like this:

```html
<!-- On your HTML code... -->
<body class="bg-white dark:bg-gray-900">
  <!-- Your content here... -->
</body>
```

And that's it folks, we can start implementing our own Dark website! 🎉

## What about `hover` or `focus`?

This could be a tricky situation, for example, when you change the color of an
element based on a `hover` interaction. The most common solution I've seen is
that many people end up implementing both a `dark-hover` and `dark-focus`
variants.

The good news is that it's not needed for most of the use cases 🧐.

There's actually a (not so) secret
[Tailwind feature](https://tailwindcss.com/docs/pseudo-class-variants#combining-with-responsive-prefixes)
that allows us to combine responsive prefixes with interaction variants!

As seen in the
[Tailwind docs](https://tailwindcss.com/docs/pseudo-class-variants#combining-with-responsive-prefixes),
we can use orange-based colors for a button on certain screen sizes, and
green-based colors for the other screen sizes 😮:

```html
<button
  class="bg-orange-500 hover:bg-orange-600 sm:bg-green-500 sm:hover:bg-green-600 md:bg-red-500 md:hover:bg-red-600 lg:bg-indigo-500 lg:hover:bg-indigo-600 xl:bg-pink-500 xl:hover:bg-pink-600"
>
  Button
</button>
```

Look carefully... There's a `sm:hover:bg-green-600` class! So, as our `dark`
query is a _responsive_ prefix, then it means we could switch `sm` for `dark`
and follow the same naming conventions to get `hover` and `focus` variants
working... And the answer is _YES_!

If we want to use a `white`-based colors for a button in our Light scheme, and
`gray`-based colors for the same button in our Dark scheme, we can write
something like:

```html
<button
  class="bg-white hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700"
>
  <!-- ... -->
</button>
```

This will indicate that:

- When on Light scheme, our button will have a white background, and a subtle
  gray when hovered.
- When on Dark scheme, our button will have a darker background, and a slightly
  lighter color when hovered.

With this, we can start expanding our coloring schemes to give those Dark users
the feeling they truly want and prevent _soaring eyes_ (DEV pun intended).
