/// <reference path="../.astro/types.d.ts" />
/// <reference types="astro/client-image" />

export type PostMetadata = {
    title: string
    description: string
    url: string
    date: string
    image?: string
    excerpt?: string
}