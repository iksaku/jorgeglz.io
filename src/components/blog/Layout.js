import Link from 'next/link'

export default function BlogLayout({ children }) {
  return (
    <div className="w-full min-h-screen h-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col">
      <header className="w-full bg-gray-50 dark:bg-gray-800 border-b border-gray-400 dark:border-gray-600">
        <nav className="md:container flex items-center justify-between px-4 py-2 md:mx-auto">
          <Link href="/">
            <a className="block hocus:text-blue-700 dark:hocus:text-blue-500 text-2xl font-semibold focus:ring ring-blue-500 focus:outline-none">
              JorgeGlz
            </a>
          </Link>
        </nav>
      </header>

      <div className="flex-grow md:container md:px-4 py-4 md:mx-auto">
        <div className="max-w-6xl mx-auto space-y-4">{children}</div>
      </div>

      <div className="w-full bg-gray-50 dark:bg-gray-800 border-t border-gray-500 dark:border-gray-600">
        <footer className="md:container flex items-center justify-between p-4 md:mx-auto">
          <div className="font-bold">&copy; 2019 - 2021</div>
        </footer>
      </div>
    </div>
  )
}
