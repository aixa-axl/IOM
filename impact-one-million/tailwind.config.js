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
        // Figma type tokens — desktop sizes (mobile overrides in src/input.css <1024px)
        body: ['18px', { lineHeight: '1.2' }],           // mobile 16
        label: ['20px', { lineHeight: '1.2' }],          // same on mobile (nav)
        'card-title': ['24px', { lineHeight: '1' }],     // mobile 20
        header: ['36px', { lineHeight: '1' }],           // mobile 24
        'stat-label': ['32px', { lineHeight: '1.2', letterSpacing: '0.04em' }], // mobile 20
        'feature-title': ['48px', { lineHeight: '39px' }], // mobile 32
        quote: ['48px', { lineHeight: '48px' }],         // mobile 32
        number: ['60px', { lineHeight: '1' }],           // mobile 36
        headline: ['56px', { lineHeight: '1.2' }],       // mobile 32
        title: ['72px', { lineHeight: '1.1', letterSpacing: '0.02em' }], // mobile 40
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
        page: '26px', // mobile L/R inset; tablet 30px via input.css md+
      },
    },
  },
  plugins: [],
};
