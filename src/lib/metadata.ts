import type { Writable } from 'svelte/store'
import { writable } from 'svelte/store'

type Metadata = {
  title?: string
  description?: string
  image?: string
  twitter_card?: 'summary' | 'summary_large_image'
}

export const metadata: Writable<Metadata> = writable({})

metadata.subscribe((metadata) => {
  if (metadata.image) {
    metadata.twitter_card = 'summary_large_image'
  }
})

export function useDefaultMetadata(): void {
  metadata.set({})
}
