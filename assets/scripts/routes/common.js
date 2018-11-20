import AOS from 'aos';
import 'magnific-popup';
import 'rellax';
import 'slick-carousel';

export default {
  init() {
    // JavaScript to be fired on all pages
    $(document).foundation();

    // AOS library
    AOS.init();

    // Rellax
    var rellax = new Rellax('.rellax', { // eslint-disable-line
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
