function importPosts(r) {
  return r.keys().map((fileName) => ({
    link: fileName.substr(1).replace(/\/index\.mdx$/, ''),
    module: r(fileName),
  }))
}

function dateSortDesc(a, b) {
  if (a > b) return -1
  if (a < b) return 1
  return 0
}

export function getAllPostPreviews() {
  return importPosts(
    require.context('./pages/?preview', true, /\.mdx$/)
  ).sort((a, b) => dateSortDesc(a.module.meta.date, b.module.meta.date))
}
