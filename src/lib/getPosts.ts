type GlobImport = Record<string, PostComponent>

type PostComponent = {
  metadata: {
    title: string
    description: string
    date?: string
  }
}

type ProcessedPost = PostComponent['metadata'] & {
  url: string
}

type PostCollection = ProcessedPost[]

const getRelativeUrl = (file: string): string =>
  '/blog/' +
  file
    // Removes internal blog directory
    .replace(/^.*\/blog\//, '')
    // Removes file extension, and keeps only filename or directory name if nested
    .replace(/(\/index)?\..*$/, '')

export const getPosts = (): PostCollection => {
  return Object.entries(import.meta.globEager('../routes/blog/**/*.svx') as GlobImport)
    .map(([file, component]) => ({
      ...component.metadata,
      url: getRelativeUrl(file)
    }))
    .filter((post) => !!post.date)
    .sort((a, b) => {
      // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-ignore
      a = new Date(a.date)
      // eslint-disable-next-line @typescript-eslint/ban-ts-comment
      // @ts-ignore
      b = new Date(b.date)

      if (a < b) return 1
      if (a > b) return -1
      return 0
    })
}
