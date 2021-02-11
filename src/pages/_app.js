import 'tailwindcss/tailwind.css'
import Head from 'next/head'
import { DefaultSeo } from 'next-seo'
import BlogLayout from '@/components/blog/Layout'

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

      <BlogLayout>
        <Component {...pageProps} />
      </BlogLayout>
    </>
  )
}
