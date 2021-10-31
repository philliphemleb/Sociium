module.exports = {
  purge: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        gridTemplateRows: {
            '12': 'repeat(12, minmax(0, 1fr))',
        },
        gridRow: {
            'span-11': 'span 11 / span 11',
            'span-12': 'span 12 / span 12',
        }
    },
  },
  variants: {
    extend: {
        animation: ['hover']
    },
  },
  plugins: [],
}
