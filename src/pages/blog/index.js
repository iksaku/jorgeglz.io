import { getAllPostPreviews } from '@/getPosts'
import Post from '../../components/blog/Post'

export default function PostsList() {
  return getAllPostPreviews().map(
    ({ link, module: { default: Component, meta } }) => {
      return (
        <Post key={link} link={link} meta={meta} isPreview>
          <Component />
        </Post>
      )
    }
  )
}
