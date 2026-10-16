module.exports = {
  content: [
    '../*.html',
    '../admin/**/*.php',
    '../includes/**/*.php',
    '../*.php',
    '../app.js',
  ],
  theme: {
    extend: {
      colors: {
        trade: {
          50: '#f0f9ff',
          100: '#e0f2fe',
          500: '#0284c7',
          600: '#0369a1',
          700: '#075985',
          900: '#0f172a',
          950: '#0b1120',
        }
      }
    }
  }
}
