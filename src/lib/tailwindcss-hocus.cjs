const plugin = require('tailwindcss/plugin.js')

module.exports = plugin(({addVariant}) => {
  addVariant('hocus', ['&:hover', '&:focus'])
})
