const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./svelte/src/**/*.{html,js,ts,svelte}"],
  theme: {
    extend: {
      fontFamily: {
        'akshar': ['"Akshar"', ...defaultTheme.fontFamily.sans]
      },
      colors: {
        'yellow-green': {
          '50': '#f6fbea',
          '100': '#eaf5d2',
          '200': '#cbe896',
          '300': '#b8de78',
          '400': '#9cce4d',
          '500': '#7eb32f',
          '600': '#608e22',
          '700': '#4b6d1e',
          '800': '#3e571d',
          '900': '#354a1d',
          '950': '#1a280b',
        },
        'bright-gray': {
          '50': '#f6f7f9',
          '100': '#eceef2',
          '200': '#d4d9e3',
          '300': '#afb8ca',
          '400': '#8492ac',
          '500': '#647493',
          '600': '#505d79',
          '700': '#414b63',
          '800': '#373f51',
          '900': '#333947',
          '950': '#22262f',
        },
        'pelorous': {
          '50': '#f2f9f9',
          '100': '#ddeff0',
          '200': '#bedfe3',
          '300': '#92c7ce',
          '400': '#58a4b0',
          '500': '#428b98',
          '600': '#3a7380',
          '700': '#345e6a',
          '800': '#314f59',
          '900': '#2c444d',
          '950': '#192b33',
        },

      }
    },
  },
  plugins: [],
}