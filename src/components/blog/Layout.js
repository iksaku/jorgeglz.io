import Link from 'next/link'
import { useRouter } from 'next/router'

import Github from '@/components/icons/Github'
import LinkedIn from '@/components/icons/LinkedIn'
import Twitter from '@/components/icons/Twitter'

function NavLink({ href, children }) {
  const router = useRouter()
  let classNames = 'border-b-2 focus:ring ring-blue-500 focus:outline-none '

  if (router.pathname === href) {
    classNames += 'border-blue-500'
  } else {
    classNames += 'border-transparent hover:border-blue-500'
  }

  return (
    <Link href={href}>
      <a className={classNames}>{children}</a>
    </Link>
  )
}

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

          <ul className="flex items-center space-x-4">
            <li>
              <NavLink href="/about">About</NavLink>
            </li>
          </ul>
        </nav>
      </header>

      <div className="flex-grow md:container md:px-4 py-4 md:mx-auto">
        <div className="max-w-6xl mx-auto space-y-4">{children}</div>
      </div>

      <div className="w-full bg-gray-50 dark:bg-gray-800 border-t border-gray-500 dark:border-gray-600">
        <footer className="md:container flex items-center justify-between p-4 md:mx-auto">
          <div className="font-bold">&copy; 2019 - 2021</div>

          <ul className="flex items-center space-x-4 sm:space-x-8">
            <li>
              <Link href="https://github.com/iksaku">
                <a
                  target="_blank"
                  rel="nofollow noopener noreferrer"
                  title="Jorge's Github Profile"
                >
                  <Github className="w-6 h-6" />
                </a>
              </Link>
            </li>
            <li>
              <Link href="https://www.linkedin.com/in/jorge-glz">
                <a
                  target="_blank"
                  rel="nofollow noopener noreferrer"
                  title="Jorge's LinkedIn Profile"
                >
                  <LinkedIn className="w-6 h-6" />
                </a>
              </Link>
            </li>
            <li>
              <Link href="https://twitter.com/iksaku2">
                <a
                  target="_blank"
                  rel="nofollow noopener noreferrer"
                  title="Jorge's Twitter Profile"
                >
                  <Twitter className="w-6 h-6" />
                </a>
              </Link>
            </li>
          </ul>
        </footer>
      </div>
    </div>
  )
}
