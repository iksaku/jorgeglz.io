import Image from 'next/image'
import { useState } from 'react'

export default function About({ children }) {
  const phrases = [
    "Still don't know me?",
    "Haven't we already met?",
    'So, you want to know more about me...',
    'This is me... 🎶',
    'Who am I you ask?',
    'Peeking at my blog without knowing me?',
    '¿Sabías que hablo Español? 🇲🇽',
  ]

  const getRandomPhrase = () =>
    phrases[Math.floor(Math.random() * phrases.length)]

  const [randomPhrase, setPhrase] = useState(getRandomPhrase)

  return (
    <div className="w-full space-y-8">
      {/* Avatar + Random Phrase */}
      <div
        className="w-full flex flex-col-reverse md:flex-row items-center justify-center md:space-x-8 space-y-4 space-y-reverse md:space-y-0"
        onClick={() => setPhrase(getRandomPhrase())}
      >
        <div className="relative w-32 h-32 rounded-full overflow-hidden">
          <Image
            src="https://secure.gravatar.com/avatar/dfbbacbe4acbe45486084d472bf043fb?size=512"
            alt="Jorge González's Avatar"
            layout="fill"
          />
        </div>
        <h1 className="text-3xl text-center font-bold">{randomPhrase}</h1>{' '}
      </div>
      {/* Real About Me */}
      <div className="w-full bg-gray-50 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg">
        <article className="prose dark:prose-invert prose-lg max-w-none p-4">
          {children}
        </article>
      </div>
    </div>
  )
}
