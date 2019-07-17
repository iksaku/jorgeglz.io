export const size_sm = 640
export const size_md = 768
export const size_lg = 1024
export const size_xl = 1280

export const mq = {
    isXs: () => window.innerWidth < size_sm,
    isSm: () => window.innerWidth >= size_sm && window.innerWidth < size_md,
    isMd: () => window.innerWidth >= size_md && window.innerWidth < size_lg,
    isLg: () => window.innerWidth >= size_lg && window.innerWidth < size_xl,
    isXl: () => window.innerWidth >= size_xl
}

export default mq