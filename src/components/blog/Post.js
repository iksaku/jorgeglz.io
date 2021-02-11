import 'dracula-prism/css/dracula-prism.css'
import Image from 'next/image'
import Link from 'next/link'
import dayjs from 'dayjs'
import { NextSeo } from 'next-seo'

export default function Post({ link, meta, children, isPreview }) {
  let title = meta.title

  if (link) {
    title = (
      <Link href={link}>
        <a className="block hocus:text-blue-700 dark:hocus:text-blue-500 focus:ring ring-blue-500 focus:outline-none">
          {meta.title}
        </a>
      </Link>
    )
  }

  const date = dayjs(meta.date)
  let formattedDate = date.toISOString()

  if (process.browser) {
    formattedDate = date.format('MMMM DD, YYYY')
  }

  return (
    <>
      {!isPreview && (
        <NextSeo title={meta.title} description={meta.description} />
      )}

      <article className="w-full bg-gray-50 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg divide-y divide-gray-400 dark:divide-gray-600">
        {/* Metadata */}
        <div className="px-4 py-2 space-y-2">
          {/* Title */}
          <h1 className="text-2xl font-semibold">{title}</h1>

          <div className="flex items-center text-gray-700 dark:text-gray-300 text-sm md:text-base font-medium space-x-8">
            {/* Author */}
            <Link href="/about">
              <a className="flex items-center hocus:text-blue-700 dark:hocus:text-blue-500 focus:ring ring-blue-500 focus:outline-none space-x-1">
                <div className="relative w-8 h-8 rounded-full overflow-hidden">
                  <Image
                    src="https://secure.gravatar.com/avatar/dfbbacbe4acbe45486084d472bf043fb?size=80"
                    alt="Jorge González's Avatar"
                    layout="fill"
                  />
                </div>
                <span>Jorge González</span>
              </a>
            </Link>

            {/* Publish Date */}
            <div className="flex items-center space-x-1">
              <span>📅</span>
              <time dateTime={date.toISOString()}>{formattedDate}</time>
            </div>
          </div>
        </div>

        {/* Content */}
        <div className="prose dark:prose-light prose-lg max-w-none px-4 py-2">
          {children}

          {isPreview && (
            <Link href={link}>
              <a className="focus:ring ring-blue-500 focus:outline-none">
                Continue Reading →
              </a>
            </Link>
          )}
        </div>
      </article>
    </>
  )
}
