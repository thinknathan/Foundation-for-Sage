import AOS from 'aos';
import Rellax from 'rellax';
import Headroom from 'headroom.js';
import navigation from '@10up/component-navigation';

export default {
  init() {
    /*
     * Init AOS
     * Animations on scroll
     */
    AOS.init();

    /*
     * Init Relax
     * Parallax effects
     */
    new Rellax('.rellax', {
      speed: -2,
      center: false,
      wrapper: null,
      round: true,
      vertical: true,
      horizontal: false,
    });

    /*
     * Init Headroom
     * Hide your header until you need it
     */
    var myElement = document.querySelector(".headroom");
    var headroom = new Headroom(myElement);
    headroom.init();

    /*
     * Init navigation
     * Horizontal navigation on large screen, and collapses down to an off-canvas model on small viewports
     */
    new navigation('#menu-primary', {
      action: 'hover',
      breakpoint: '(min-width: 40em)',
    });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
