import AOS from 'aos';
import Headroom from 'headroom.js';
import stickybits from 'stickybits';
import MetisMenu from 'metismenujs';
import Froffcanvas from 'fr-offcanvas';
import prefersReducedMotion from '../util/prefersReducedMotion.js';
import queueByElement from '../util/queueByElement.js';
//import delegateListener from '../util/delegateListener.js';
//import forEach from '../util/forEach.js';

export default {
  init() {

    /**
     * Init AOS
     * Animations on scroll
     * @link https://michalsnik.github.io/aos/
     */
    if (!prefersReducedMotion()) {
      AOS.init({
        easing: 'ease-in',
      });
    }


    /**
     * Init Headroom
     * Hide your header until you need it
     * @link https://wicky.nillia.ms/headroom.js/
     */
    let headroomElement = '.header--site';
    queueByElement(headroomElement, function () {
      let headroom = new Headroom(this, {
        offset: 300,
        // scroll tolerance in px before state changes
        tolerance: 6,
        classes: {
          // when element is initialised
          initial: "is-headroom",
          // when scrolling up
          pinned: "is-headroom--pinned",
          // when scrolling down
          unpinned: "is-headroom--unpinned",
          // when above offset
          top: "is-headroom--top",
          // when below offset
          notTop: "is-headroom--not-top",
          // when at bottom of scoll area
          bottom: "is-headroom--bottom",
          // when not at bottom of scroll area
          notBottom: "is-headroom--not-bottom",
          // when frozen method has been called
          frozen: "is-headroom--frozen"
        },
      });
      headroom.init();
    });


    /**
     * Init MetisMenu navigation
     * Dropdown menu
     * @link https://github.com/onokumus/metismenujs
     */
    let navigationElement = '#menu--primary';
    queueByElement(navigationElement, function () {
      let mm1 = new MetisMenu(navigationElement).on("shown.metisMenu", function (event) {
        window.addEventListener("click", function mmClick1(e) {
          if (!event.target.contains(e.target)) {
            mm1.hide(event.detail.shownElement);
            window.removeEventListener("click", mmClick1);
          }
        });
      });
    });

    let navigationOffcanvasElement = '#menu--offcanvas';
    queueByElement(navigationOffcanvasElement, function () {
      new MetisMenu(navigationOffcanvasElement);
    });


    /*
     * Init StickyBits
     * Polyfill for position: sticky
     * @link https://dollarshaveclub.github.io/stickybits/
     */
    // Stick header to the top
    let stickyElementTop = '.header--site';
    queueByElement(stickyElementTop, function () {
      stickybits(stickyElementTop);
    });

    // Stick navbar to the bottom
    let stickyElementBottom = '.nav--navbar';
    queueByElement(stickyElementBottom, function () {
      stickybits(stickyElementBottom, {
        verticalPosition: 'bottom',
      });
    });


    /*
     * Fix for `.card-single-link` elements
     * Makes the entirety of the card clickable
     * @link https://inclusive-components.design/cards/
     */
    let cards = '.card--single-link';
    queueByElement(cards, function () {
      let down, up, link = this.querySelector('h2 a');
      this.onmousedown = () => down = +new Date();
      this.onmouseup = () => {
        up = +new Date();
        if ((up - down) < 150) {
          link.click();
        }
      };
    });


    /*
     * Init fr-offcanvas
     * Toggleable offcanvas panel
     * @link https://frend.co/components/offcanvas/
     */
    let offCanvasElement = '.offcanvas';
    queueByElement(offCanvasElement, function () {
      new Froffcanvas({
        // String - Panel selector, hook for JS init() method
        selector: offCanvasElement,

        // String - Selector for the open button(s)
        openSelector: offCanvasElement + '__open',

        // String - Selector for the close button
        closeSelector: offCanvasElement + '__close',

        // Boolean - Prevent click events outside panel from triggering close
        preventClickOutside: false,

        // String - Class name that will be added to the selector when the component has been initialised
        readyClass: 'offcanvas--is-ready',

        // String - Class name that will be added to the selector when the panel is visible
        activeClass: 'offcanvas--is-active',
      });

    });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    /**
     * Init Privacy Callout
     */
    queueByElement('#callout--privacy', function () {
      import('../components/privacy-banner.js').then(init => init.default.call(this)); // jshint ignore:line
    }, true);


    /**
     * Init Relax
     * Parallax effects
     * @link https://github.com/dixonandmoe/rellax
     */
    let rellaxElement = '.rellax';
    queueByElement(rellaxElement, function () {
      import('../components/rellax.js').then(init => init.default.call(this)); // jshint ignore:line
    });


    /**
     * Init Glider.js
     * Carousel, fast and accessible
     * @link https://nickpiscitelli.github.io/Glider.js/
     */
    let carouselElement = '.carousel';
    queueByElement(carouselElement, function () {
      import('../components/carousel.js').then(init => init.default.call(this)); // jshint ignore:line
    });


    /*
     * Init fr-accordion
     * Accordion, lightweight and accessible
     * @link https://frend.co/components/accordion/
     */
    let accordionElement = '.accordion';
    queueByElement(accordionElement, function () {
      import('../components/accordion.js').then(init => init.default.call(this, accordionElement)); // jshint ignore:line
    });


    /*
     * Init Tobi
     * Lightbox, light-weight and accessible
     * @link https://github.com/rqrauhvmra/Tobi
     */
    let lightboxElement = '.lightbox';
    queueByElement(lightboxElement, function () {
      import('../components/lightbox.js').then(init => init.default.call(this)); // jshint ignore:line
    });


    /*
     * Init Dialog/Modal
     * Dialog or modal
     * @link https://frend.co/components/dialogmodal/
     */
    let dialogElement = '.dialogmodal';
    queueByElement(dialogElement, function () {
      import('../components/dialogmodal.js').then(init => init.default.call(this, dialogElement)); // jshint ignore:line
    });


    /*
     * Init fr-tabs
     * Accessible tab system
     * @link https://frend.co/components/tabs/
     */
    let tabsElement = '.tabs';
    queueByElement(tabsElement, function () {
      import('../components/tabs.js').then(init => init.default.call(this, tabsElement)); // jshint ignore:line
    });


    /*
     * Init Pikaday
     * A refreshing JavaScript Datepicker
     * @link https://github.com/Pikaday/Pikaday
     */
    let datePickerElement = '#datepicker';
    queueByElement(datePickerElement, function () {
      import('../components/calendar.js').then(init => init.default.call(this)); // jshint ignore:line
    });


    /*
     * Init Social Share
     * @link https://10up.github.io/wp-component-library/component/social-links/index.html
     * @license MIT
     * @copyright 10up
     */
    let shareContainer = '.social-share';
    queueByElement(shareContainer, function () {
      import('../components/social-share.js').then(init => init.default.call(this)); // jshint ignore:line
    });
  },
};
