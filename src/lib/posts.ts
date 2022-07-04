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
    .filter((post) => import.meta.env.DEV || !!post.date)
    .sort((a, b) => {
      // Convert dates to timestamp representation. When undefined or null, convert to 0 (meaning it is a draft)
      const timestamp = (date: string | null = null) => Number(date ? new Date(date) : null)
      const dateA = timestamp(a.date)
      const dateB = timestamp(b.date)

      // Order Drafts first
      if (!a.date || !b.date) {
        return Math.sign(dateA - dateB)
      }

      // Non-drafts order in a descending order
      return Math.sign(dateB - dateA)
    })
}
