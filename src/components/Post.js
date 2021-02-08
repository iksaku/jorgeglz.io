import Image from 'next/image'
import Link from 'next/link'
import dayjs from 'dayjs'
import { NextSeo } from 'next-seo'

export default function Post({ link, meta, children, isPreview }) {
  let title = meta.title

  if (link) {
    title = (
      <Link href={link}>
        <a className="hocus:text-blue-700 focus:ring ring-blue-500 focus:outline-none">
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

      <div className="min-w-full w-full bg-gray-50 md:border-x border-y md:rounded-lg divide-y">
        {/* Metadata */}
        <div className="px-4 py-2 space-y-2">
          {/* Title */}
          <h1 className="text-2xl font-semibold">{title}</h1>

          <div className="flex items-center text-gray-700 text-sm md:text-base font-medium space-x-8">
            {/* Author */}
            <Link href="/about">
              <a className="flex items-center space-x-1">
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
        <div className="prose prose-lg max-w-none px-4 py-2">{children}</div>
      </div>
    </>
  )
}
