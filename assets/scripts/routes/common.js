import AOS from 'aos';
import Rellax from 'rellax';
import Headroom from 'headroom.js';
import navigation from '@10up/component-navigation';
import Glider from 'glider-js';
import Fraccordion from 'fr-accordion';
import Tobi from 'rqrauhvmra__tobi';
import A11yDialog from 'a11y-dialog';
import stickybits from 'stickybits';
import '../util/socialShare.js';

export default {
  init() {
    /*
     * Init AOS
     * Animations on scroll
     * @link https://michalsnik.github.io/aos/
     */
    AOS.init();

    /*
     * Init Relax
     * Parallax effects
     * @link https://github.com/dixonandmoe/rellax
     */
    let rellaxElement = '.rellax';
    new Rellax(rellaxElement, {
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
     * @link https://wicky.nillia.ms/headroom.js/
     */
    let headroomElement = document.querySelector(".headroom");
    let headroom = new Headroom(headroomElement, {
      offset: 300,
      // scroll tolerance in px before state changes
      tolerance: 6,
    });
    headroom.init();

    /*
     * Init navigation
     * Horizontal navigation on large screen, collapses down to an off-canvas model on small viewports
     * @link https://github.com/10up/component-navigation
     */
    let navigationElement = '#menu-primary';
    new navigation(navigationElement, {
      action: 'hover',
      breakpoint: '(min-width: 40em)',
    });

    /*
     * Init Glider.js
     * Carousel, fast and accessible
     * @link https://nickpiscitelli.github.io/Glider.js/
     */
    let carouselElement = document.querySelector('.carousel-inner');
    new Glider(carouselElement, {
      // Mobile-first defaults
      slidesToShow: 1,
      slidesToScroll: 1,
      scrollLock: true,
      dots: '#resp-dots',
      arrows: {
        prev: '.glider-prev',
        next: '.glider-next',
      },
      responsive: [
        {
          // screens greater than >= 775px
          breakpoint: 775,
          settings: {
            // Set to `auto` and provide item width to adjust to viewport
            slidesToShow: 2,
            slidesToScroll: 1,
            itemWidth: 150,
            duration: 0.25,
          },
        },
        {
          // screens greater than >= 1024px
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            itemWidth: 150,
            duration: 0.25,
          },
        },
      ],
    });

    /*
     * Init fr-accordion
     * Accordion, lightweight and accessible
     * @link https://frend.co/components/accordion/
     */
    let accordionElement = '.js-fr-accordion';
    new Fraccordion({
      // String - Outer container selector, hook for JS init() method
      selector: accordionElement,

      // String - Accordion header elements converted to focusable, togglable elements
      headerSelector: '.js-fr-accordion__header',

      // String - Use header id on element to tie each accordion panel to its header - see panelIdPrefix
      headerIdPrefix: 'accordion-header',

      // String - Accordion panel elements to expand/collapse
      panelSelector: '.js-fr-accordion__panel',

      // String - Use panel id on element to tie each accordion header to its panel - see headerIdPrefix
      panelIdPrefix: 'accordion-panel',

      // Boolean - If set to false, all accordion panels will be closed on init()
      firstPanelsOpenByDefault: true,

      // Boolean - If set to false, each accordion instance will only allow a single panel to be open at a time
      multiselectable: false,

      // String - Class name that will be added to the selector when the component has been initialised
      readyClass: 'fr-accordion--is-ready',

      // Integer - Duration (in milliseconds) of CSS transition when opening/closing accordion panels
      transitionLength: 250,
    });

    /*
     * Init Tobi
     * Lightbox, light-weight and accessible
     * @link https://github.com/rqrauhvmra/Tobi
     */
    new Tobi();

    /*
     * Init A11yDialog
     * Dialog or modal
     * @link https://github.com/edenspiekermann/a11y-dialog
     */
    let dialogElement = document.getElementById('my-accessible-dialog');
    new A11yDialog(dialogElement);

    /*
     * Init StickyBits
     * Polyfill for position: sticky
     * @link https://dollarshaveclub.github.io/stickybits/
     */
    let stickyElementTop = '.stick-to-top';
    stickybits(stickyElementTop);

    let stickyElementBottom = '.stick-to-bottom';
    stickybits(stickyElementBottom, {
      verticalPosition: 'bottom',
    });

    /*
     * Init Social Links
     * Popup for social share buttons
     * @link https://10up.github.io/wp-component-library/component/social-links/index.html
     */
    TenUp.socialLinks({
      'target': '.social-share',
      'window_height': 450,
      'window_width': 625,
    });

    /*
     * Fix for `.card-single-link` elements
     * Makes the entirety of the card clickable
     * @link https://inclusive-components.design/cards/
     */

    const cards = document.querySelectorAll('.card-single-link');
    Array.prototype.forEach.call(cards, card => {
      let down, up, link = card.querySelector('h2 a');
      card.onmousedown = () => down = +new Date();
      card.onmouseup = () => {
        up = +new Date();
        if ((up - down) < 150) {
          link.click();
        }
      }
    });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
