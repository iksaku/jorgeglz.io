import type { RequestHandler } from '@sveltejs/kit'

export const get: RequestHandler = () => ({
  status: 302,
  headers: {
    location: `/blog`
  }
})
