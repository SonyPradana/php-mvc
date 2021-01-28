module.exports = {
  purge: [

    './resources/**/*.template.php',

    './resources/**/*.js',

    // optional
    './resources/vue/**/*.vue'

  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
