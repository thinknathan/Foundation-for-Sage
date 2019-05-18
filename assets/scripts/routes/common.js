import AOS from 'aos';
import Rellax from 'rellax';

export default {
  init() {
    // AOS library
    AOS.init();

    // Rellax
    new Rellax('.rellax', {
      speed: -2,
      center: false,
      wrapper: null,
      round: true,
      vertical: true,
      horizontal: false,
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
