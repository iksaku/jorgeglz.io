import { getCollection, type CollectionEntry } from 'astro:content'
import { DateTime } from 'luxon'

type BlogEntry = CollectionEntry<'blog'>
export type BlogPost = Omit<BlogEntry, 'data'> & {
  data: Omit<BlogEntry['data'], 'date'> & {
    date?: DateTime
  }
}

export async function getBlogPosts(filter?: (entry: CollectionEntry<'blog'>) => boolean) {
  return (await getCollection('blog', filter))
    .map((post): BlogPost => {
      const toDateTime = (date?: Date) =>
        !date ? date : DateTime.fromJSDate(date, { zone: 'utc' }).setZone('America/Monterrey', { keepLocalTime: true })

      return {
        ...post,
        data: {
          ...post.data,
          date: toDateTime(post.data.date),
        },
      }
    })
    .sort((postA: BlogPost, postB: BlogPost) => {
      if (!postA.data.date) return -1
      if (!postA.data.date) return 1

      return Math.sign(postB.data.date!.toSeconds() - postA.data.date!.toSeconds())
    })
}
