import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brown: {
          600: '#7c4d0f',
          700: '#5e3b0b',
        },
        stone: {
          200: '#e7e5e4',
          900: '#1c1917',
        },
      },
    },
  },
  plugins: [forms],
};
