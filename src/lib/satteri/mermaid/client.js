import mermaid from 'mermaid'

mermaid.initialize({
  startOnLoad: true,
  // Dracula-flavored base theme to match the site's code blocks.
  theme: 'base',
  themeVariables: {
    background: 'transparent',
    fontFamily: 'var(--font-sans)',
    primaryColor: '#282a36',
    primaryTextColor: '#f8f8f2',
    primaryBorderColor: '#6272a4',
    secondaryColor: '#44475a',
    secondaryTextColor: '#f8f8f2',
    tertiaryColor: '#21222c',
    lineColor: '#f8f8f2',
    textColor: '#f8f8f2',
    actorBkg: '#282a36',
    actorBorder: '#6272a4',
    actorTextColor: '#f8f8f2',
    signalColor: '#f8f8f2',
    signalTextColor: '#f8f8f2',
    sequenceNumberColor: '#282a36',
    activationBkgColor: '#44475a',
    noteBkgColor: '#44475a',
    noteTextColor: '#f8f8f2',
    noteBorderColor: '#6272a4',
  },
})
