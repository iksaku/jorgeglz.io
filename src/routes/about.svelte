<script context='module'>
  import BlogLayout from '../components/blog/Layout.svelte'

  const phrases = [
    'Still don\'t know me?',
    'Haven\'t we already met?',
    'So, you want to know more about me...',
    'This is me... 🎶',
    'Who am I you ask?',
    'Peeking at my blog without knowing me?',
    '¿Sabías que hablo Español? 🇲🇽'
  ]

  const getRandomPhrase = () => phrases[Math.floor(Math.random() * phrases.length)]
</script>

<script>
  let phrase = phrases[0]
</script>

<BlogLayout>
  <div class='w-full space-y-8'>
    <!-- Avatar + Random Phrase -->
    <div
      class='w-full flex flex-col-reverse md:flex-row items-center justify-center md:space-x-8 space-y-4 space-y-reverse md:space-y-0'
      on:click={() => phrase = getRandomPhrase()}
    >
      <img
        src='https://secure.gravatar.com/avatar/dfbbacbe4acbe45486084d472bf043fb?size=512'
        alt="Jorge González's Avatar"
        class='w-32 h-32 aspect-square rounded-full overflow-hidden'
      />
      <h1 class='text-3xl text-center font-bold'>{phrase}</h1>
    </div>

    <!-- About Me -->
    <div
      class='w-full bg-gray-50 dark:bg-gray-800 md:border-x border-y border-gray-400 dark:border-gray-600 md:rounded-lg'>
      <article class='prose dark:prose-invert prose-lg max-w-none p-4'>
        <h3>About Me, Myself, and I</h3>

        <p>
          My name is Jorge González, also known in the online work as <i>iksaku</i>. I was born
          in Mexico 🇲🇽 and I like tech-related stuff, food and also sports (not as a
          spectator but as a player, even if I'm not the most proficient one).
        </p>

        <p>
          My sport of choice is Karate 🥋, I've been practicing since I was 7 years old,
          and I've got the opportunity to be under the guidance of a lot of excellent
          sensei here from Mexico, as well as from Guatemala, Spain and Japan directly.
        </p>

        <p>
          I'm currently studying a <i>Software Engineering</i> degree, which I hope to finish
          around year 2022. To be honest, I don't feel like I'm learning new tech-related
          stuff at school, since I've been learning and studying on those lands for quite
          some time already, but I'm truly getting better for Math and Physics stuff.
        </p>

        <h3>Main Programming Languages</h3>

        <ul>
          <li>
            The always loyal <a href='https://www.php.net/' target='_blank' rel='noopener noreferrer'>PHP</a>
          </li>
          <li>
            The complex <a href='https://dotnet.microsoft.com/' target='_blank' rel='noopener noreferrer'>.NET</a>
          </li>
          <li>
            The simple, yet powerful
            <a href='https://developer.mozilla.org/en-US/docs/Web/JavaScript' target='_blank' rel='noopener noreferrer'>
              JavaScript
            </a>
          </li>
          <li>
            The intelligent <a href='https://www.python.org/' target='_blank' rel='noopener noreferrer'>Python</a>
          </li>
        </ul>

        <h3>Personal Facts</h3>

        <ul>
          <li>💍 I'm married.</li>
          <li>🥋 In Karate, I have got up to Black Belt 1° Dan.</li>
          <li>📚 I started learning English by myself at the age of 6.</li>
          <li>
            🎤 I get to learn the lyrics of many songs, but fail to remember the name of the songs, the bands or the
            artists.
          </li>
          <li>🤢 I don't like onion, garlic nor avocado.</li>
        </ul>
      </article>
    </div>
  </div>
</BlogLayout>
