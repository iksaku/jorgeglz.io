import { z, defineCollection, image } from 'astro:content'

export const collections = {
    'blog': defineCollection({
        schema: z.object({
            title: z.string().min(1),
            description: z.string().min(1),
            date: z.date().optional(),
            image: image().optional()
        })
    })
}