import 'tailwindcss/tailwind.css'
import Head from 'next/head'
import Link from 'next/link'
import { DefaultSeo } from 'next-seo'

export default function MyApp({ Component, pageProps }) {
  return (
    <>
      <Head>
        <title>JorgeGlz</title>
        <link rel="preconnect" href="https://rsms.me" />
        <link rel="dns-prefetch" href="https://rsms.me" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

        <link rel="preconnect" href="https://secure.gravatar.com" />
        <link rel="dns-prefetch" href="https://secure.gravatar.com" />
      </Head>

      <DefaultSeo
        defaultTitle="JorgeGlz"
        titleTemplate="%s | JorgeGlz"
        description="Hello! I have a blog! And here you can find... Well... Blog posts..."
        openGraph={{
          type: 'website',
        }}
        twitter={{
          site: '@iksaku2',
          cardType: 'summary',
        }}
      />

      <div className="w-full min-h-screen h-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col">
        <header className="w-full bg-gray-50 dark:bg-gray-800 border-b border-gray-400 dark:border-gray-600">
          <nav className="md:container flex items-center justify-between px-4 py-2 md:mx-auto">
            <Link href="/">
              <a className="text-2xl font-semibold">JorgeGlz</a>
            </Link>
          </nav>
        </header>

        <div className="flex-grow md:container flex md:px-4 py-4 md:mx-auto">
          <div className="max-w-6xl mx-auto space-y-4">
            <Component {...pageProps} />
          </div>
        </div>

        <footer className="w-full bg-gray-50 flex items-center justify-between p-4 sm:px-6 lg:px-8 border-t">
          Footer
        </footer>
      </div>
    </>
  )
}
