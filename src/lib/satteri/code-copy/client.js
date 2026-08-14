(() => {
  async function copyText(text) {
    try {
      if (window.isSecureContext && navigator.clipboard) {
        await navigator.clipboard.writeText(text)
        return true
      }
    } catch {
      /* fall through to execCommand */
    }
    const ta = document.createElement('textarea')
    ta.value = text
    ta.style.cssText = 'position:fixed;opacity:0;pointer-events:none'
    document.body.appendChild(ta)
    ta.select()
    try {
      return document.execCommand('copy')
    } catch {
      return false
    } finally {
      ta.remove()
    }
  }

  document.querySelectorAll('.code-frame-copy').forEach((button) => {
    button.addEventListener('click', async () => {
      const label = button.querySelector('span')
      const code = button.closest('.code-frame')?.querySelector('pre code')
      const ok = await copyText(code?.textContent ?? '')

      clearTimeout(button._copyTimer)
      if (label) label.textContent = ok ? 'Copied!' : 'Failed'
      button.classList.toggle('copied', ok)
      button._copyTimer = setTimeout(() => {
        if (label) label.textContent = 'Copy'
        button.classList.remove('copied')
      }, 1600)
    })
  })
})()
