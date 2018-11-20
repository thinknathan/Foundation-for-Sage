/* eslint-disable */

//import postcssFontGrabber from 'postcss-font-grabber';
const autoprefixer = require('autoprefixer');
const cleancss = require('postcss-clean');
const fontMagician = require('postcss-font-magician');

const cleancssConfig = {
  level: {
    1: {
      all: true,
      specialComments: 0,
    },
    2: {
      all: false,
      removeDuplicateRules: true,
    },
  },
};

module.exports = ({
  file,
  options
}) => {
  return {
    parser: options.enabled.optimize ? 'postcss-safe-parser' : undefined,
    plugins: [
      fontMagician({
        foundries: 'google',
        display: 'fallback',
        protocol: 'https:',
        variants: {
          'Montserrat': {
            '300': [],
            '400': [],
            '700': [],
          },
        },
      }),
      /*
      postcssFontGrabber({
        fontDir: 'assets/fonts/',
        mkdir: true,
      }),
      */
      autoprefixer(),
      cleancss(options.enabled.optimize ? cleancssConfig : false),
    ],
  };
};
