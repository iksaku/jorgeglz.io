import Link from 'next/link'
import { useRouter } from 'next/router'

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
              {/*<Link href="/about">
                <a className="border-b-2 border-transparent hover:border-blue-500 focus:ring ring-blue-500 focus:outline-none">
                  About
                </a>
              </Link>*/}
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
        </footer>
      </div>
    </div>
  )
}
