import type { CollectionEntry } from 'astro:content'
import { DateTime } from 'luxon'

export function toDateTime(date: Date, tz: string = 'America/Monterrey'): DateTime {
  return DateTime.fromSQL(date.toISOString().split('T')[0]).setZone(tz)
}

type BlogEntry = CollectionEntry<'blog'>
export type BlogPost = Omit<BlogEntry, 'data'> & {
  data: Omit<BlogEntry['data'], 'date'> & {
    date?: DateTime
  }
}

export function transformBlogPost(post: CollectionEntry<'blog'>, baseUrl: URL): BlogPost {
  return {
    ...post,
    data: {
      ...post.data,
      date: !post.data.date ? undefined : toDateTime(post.data.date),
    },
  }
}

export function sortPostsByDate(postA: BlogPost, postB: BlogPost): number {
  if (!postA.data.date) return -1
  if (!postB.data.date) return 1

  return Math.sign(postB.data.date!.toSeconds() - postA.data.date!.toSeconds())
}
