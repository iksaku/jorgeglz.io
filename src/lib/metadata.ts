import type { Writable } from 'svelte/store'
import { writable } from 'svelte/store'

type Metadata = {
  title?: string
  description?: string
  image?: string
}

export const metadata: Writable<Metadata> = writable({})
