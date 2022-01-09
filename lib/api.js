export function getPostPreviews() {
  let posts = require.context('@/pages?preview', true, /blog.*\.mdx?$/)

  return posts
    .keys()
    .map((fileName) => ({
      link: fileName.substr(1).replace(/\/index\.mdx?$/, ''),
      ...posts(fileName),
    }))
    .filter((post) => !post.meta.draft)
    .sort((post1, post2) => {
      if (post1.meta.date < post2.meta.date) return 1
      if (post1.meta.date > post2.meta.date) return -1
      return 0
    })
}
