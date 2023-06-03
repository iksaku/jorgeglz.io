import type { CollectionEntry } from 'astro:content'
import { DateTime } from 'luxon'

export function toDateTime(date: Date, tz: string = 'America/Monterrey'): DateTime {
  return DateTime.fromISO(date.toISOString()).setZone(tz)
}

export type BlogPost = ReturnType<typeof transformBlogPost>

export function transformBlogPost(post: CollectionEntry<'blog'>, baseUrl: URL) {
  return {
    ...post,
    data: {
      ...post.data,
      url: new URL(`/blog/${post.slug}`, baseUrl.origin).href,
      date: !post.data.date ? undefined : toDateTime(post.data.date),
    },
  }
}

export function sortPostsByDate(postA: BlogPost, postB: BlogPost): number {
  if (!postA.data.date) return -1
  if (!postB.data.date) return 1

  return Math.sign(postB.data.date!.toSeconds() - postA.data.date!.toSeconds())
}
