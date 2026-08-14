import { glob } from 'astro/loaders'
import { z } from 'astro/zod'
import { defineCollection } from 'astro:content'

const blog = defineCollection({
  loader: glob({
    pattern: '**/*.md',
    base: './src/content/blog',
    // Posts live in date-prefixed folders (`2024-03-31-my-post/index.md`) but
    // publish at `/blog/<name>` — strip the prefix and trailing `/index.md`.
    generateId: ({ entry }) => entry.replace(/\/index\.md$/, '').replace(/^\d{4}-\d{2}-\d{2}-/, ''),
  }),
  schema: ({ image }) =>
    z.object({
      title: z.string().min(1),
      description: z.string().min(1),
      date: z.date().optional(),
      update: z.date().optional(),
      image: image().optional(),
    }),
})

export const collections = { blog }
