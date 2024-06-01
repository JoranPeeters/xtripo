/** @type {import('tailwindcss').Config} */
const plugin = require('tailwindcss/plugin')

module.exports = {
  darkMode: 'class',
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    variants: {
      extend: {
        opacity: ['group-hover'],
        scale: ['group-hover'],
      },
    },
    extend: {
      boxShadow: {
        glow: '0 0 10px 1px rgba(255, 165, 0, 0.8)', // Custom glow shadow for dark mode
      },
      height: {
        '28': '7rem',
        '36': '9rem',
        '40': '10rem',
        '52': '13rem',
        '72': '18rem',
        // Add more custom values as needed
      },
      fontSize: {
        '5,5xl' : '3.25rem', 
        '4,5xl' : '2.5rem',
      },
    },
    screens: {
      'sm': '640px',
      // => @media (min-width: 640px) { ... }

      'md': '768px',
      // => @media (min-width: 768px) { ... }

      'lg': '1024px',
      // => @media (min-width: 1024px) { ... }

      'xl': '1280px',
      // => @media (min-width: 1280px) { ... }

      '2xl': '1920px',
      // => @media (min-width: 1536px) { ... }
    },
    borderRadius: {
      '8': '0.5rem',
      '20': '1.25rem',
      'full': '9999px',
    },
    fontFamily: {
      'poppins': ['Poppins', 'sans-serif'],
      'metropolis': ['Metropolis', 'sans-serif'],
    },
    colors: {
      
      transparent: 'var(--color-transparent)',

      grey: {
        0: 'var(--color-grey-0)',
        50: 'var(--color-grey-50)',
        200: 'var(--color-grey-200)',
        400: 'var(--color-grey-400)',
        600: 'var(--color-grey-600)',
        800: 'var(--color-grey-800)',
        900: 'var(--color-grey-900)',
      },
      brand: {
        'light-green': 'var(--color-brand-light-green)',
        'green': 'var(--color-brand-green)',
        'dark-green': 'var(--color-brand-dark-green)',
        'light-orange': 'var(--color-brand-light-orange)',
        'orange': 'var(--color-brand-orange)',
        'dark-orange': 'var(--color-brand-dark-orange)',
      },
      mode: {
        light: 'var(--color-mode-light)',
        dark: 'var(--color-mode-dark)',
      },
      state: {
        success: 'var(--color-state-success)',
        error: 'var(--color-state-error)',
      },
    },
    textColor: {
      primary: 'var(--text-primary)',
      secondary: 'var(--text-secondary)',
      neutral: 'var(--text-neutral)',
      invert: 'var(--text-invert)',
      'black-neutral': 'var(--text-black-neutral)',
      'grey-neutral': 'var(--text-grey-neutral)',
      green: 'var(--text-green)',
      'dark-green': 'var(--text-dark-green)',
      'light-green': 'var(--text-light-green)',
      orange: 'var(--text-orange)',
      'dark-orange': 'var(--text-dark-orange)',
      'light-orange': 'var(--text-light-orange)',
      grey: 'var(--text-grey)',
      transparent: 'var(--text-transparent)',

    },
    backgroundColor: {
      primary: 'var(--surface-primary)',
      secondary: 'var(--surface-secondary)',
      invert: 'var(--surface-invert)',
      green: 'var(--surface-green)',
      'dark-green': 'var(--surface-dark-green)',
      'light-green': 'var(--surface-light-green)',
      orange: 'var(--surface-orange)',
      'dark-orange': 'var(--surface-dark-orange)',
      'light-orange': 'var(--surface-light-orange)',
      white: 'var(--surface-neutral-white)',
      grey: 'var(--surface-grey)',
      'light-grey': 'var(--surface-light-grey)',
      transparent: 'var(--surface-transparent)',
    },
    borderColor: {
      primary: 'var(--border-primary)',
      orange: 'var(--border-orange)',
      'dark-orange': 'var(--border-orange-dark)',
      'light-orange': 'var(--border-orange-light)',
      green: 'var(--border-green)',
      'dark-green': 'var(--border-dark-green)',
      'light-green': 'var(--border-light-green)',
      neutral: 'var(--border-neutral)',
      white: 'var(--border-white)',
      transparent: 'var(--border-transparent)',
      invert: 'var(--border-invert)',
    },
  },
  plugins: [
    plugin(function({ addBase, theme }) {
      addBase({
        'h1': { 
          fontFamily: theme('fontFamily.metropolis'),
          fontSize: theme('fontSize.4xl'), 
          fontWeight: theme('fontWeight.semibold'), 
          textColor: theme('textColor.primary'),
          lineHeight: theme('lineHeight.tight'),
          '@screen lg': {
            fontSize: theme('fontSize.5,5xl') // Large screens
          }
        },
        'h2': { 
          fontFamily: theme('fontFamily.metropolis'),
          fontSize: theme('fontSize.3xl'), 
          fontWeight: theme('fontWeight.semibold'), 
          textColor: theme('textColor.primary'),
          '@screen lg': {
            fontSize: theme('fontSize.4,5xl') // Large screens
          } 
        },
        'h3': { 
          fontFamily: theme('fontFamily.metropolis'),
          fontSize: theme('fontSize.2xl'), 
          fontWeight: theme('fontWeight.semibold'), 
          textColor: theme('textColor.primary'),
          '@screen lg': {
            fontSize: theme('fontSize.4xl') // Large screens
          }  
        },
        'h4': { 
          fontFamily: theme('fontFamily.metropolis'),
          fontSize: theme('fontSize.2xl'), 
          fontWeight: theme('fontWeight.semibold'), 
          textColor: theme('textColor.primary'),
          '@screen lg': {
            fontSize: theme('fontSize.xl') // Large screens
          }  
         },
         'p': { 
          fontFamily: theme('fontFamily.poppins'),
          fontSize: theme('fontSize.sm'), 
          fontWeight: theme('fontWeight.normal'), 
          textColor: theme('textColor.primary'),
          '@screen lg': {
            fontSize: theme('fontSize.base') // Large screens
          }  
         },
         'small': { 
          fontFamily: theme('fontFamily.poppins'),
          fontSize: theme('fontSize.xs'), 
          fontWeight: theme('fontWeight.normal'), 
          textColor: theme('textColor.primary'),
          '@screen lg': {
            fontSize: theme('fontSize.sm') // Large screens
          }  
         },
         'strong': { 
          fontFamily: theme('fontFamily.poppins'),
          fontSize: theme('fontSize.base'), 
          fontWeight: theme('fontWeight.normal'), 
          textColor: theme('textColor.primary'),
          '@screen lg': {
            fontSize: theme('fontSize.xl') // Large screens
          }  
         },
      })
    })
  ],
}
