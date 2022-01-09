import { getPostPreviews } from '~/lib/api'
import Post from '@/components/blog/Post'

export default function PostsList() {
  return getPostPreviews().map(({ default: Component, meta, link }) => {
    return (
      <Post key={link} link={link} meta={meta} isPreview>
        <Component />
      </Post>
    )
  })
}
