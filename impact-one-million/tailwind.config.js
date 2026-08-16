/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        // Figma variables — Impact One Million (AXL)
        'site-bg': '#FFFFFF',
        'off-white': '#F0F7FE',
        ink: '#101C2E',
        navy: '#002460',
        blue: '#153A81',
        accent: '#E7492E',
        'accent-blue': '#5BA6DD',
        muted: '#444651',
        paper: '#F0F7FE',
      },
      fontFamily: {
        // Londrina Solid = display / labels (self-hosted in assets/fonts)
        display: ['"Londrina Solid"', 'Impact', 'sans-serif'],
        // Foundry Context = body (self-hosted in assets/fonts)
        sans: ['"Foundry Context"', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        body: ['18px', { lineHeight: '1.2' }],
        label: ['20px', { lineHeight: '1.2' }],
        'card-title': ['24px', { lineHeight: '1' }],
        header: ['36px', { lineHeight: '1' }],
        'stat-label': ['32px', { lineHeight: '1.2', letterSpacing: '0.04em' }],
        'feature-title': ['48px', { lineHeight: '39px' }],
        number: ['60px', { lineHeight: '1' }],
        headline: ['56px', { lineHeight: '1.2' }],
        title: ['72px', { lineHeight: '1.1', letterSpacing: '0.02em' }],
      },
      borderRadius: {
        btn: '4px',
        card: '8px',
      },
      maxWidth: {
        site: '1440px',
      },
      spacing: {
        gutter: '80px',
        section: '120px',
      },
    },
  },
  plugins: [],
};
