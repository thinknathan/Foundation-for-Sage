import AOS from 'aos';
import Rellax from 'rellax';
import Headroom from 'headroom.js';
import Glider from 'glider-js';
import Fraccordion from 'fr-accordion';
import Tobi from 'rqrauhvmra__tobi';
import Frdialogmodal from 'fr-dialogmodal';
import stickybits from 'stickybits';
import '../util/socialShare.js';
import MetisMenu from 'metismenujs';
import Froffcanvas from 'fr-offcanvas';
import Frtabs from 'fr-tabs';
import Pikaday from 'pikaday';
import prefersReducedMotion from '../util/prefersReducedMotion.js';

export default {
  init() {
    // Motion and defaults
    let sliderDuration = 1;
    if (prefersReducedMotion) {
      sliderDuration = 0;
    }

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
     * Init MetisMenu navigation
     * Dropdown menu
     * @link https://github.com/onokumus/metismenujs
     */
    let navigationElement = '#menu-primary';
    new MetisMenu(navigationElement);

    let navigationOffcanvasElement = '#menu-offcanvas';
    new MetisMenu(navigationOffcanvasElement);

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
      duration: sliderDuration,
      dots: '#glider-dots-1',
      arrows: {
        prev: '#glider-prev-1',
        next: '#glider-next-1',
      },
      responsive: [
        {
          // screens greater than >= 775px
          breakpoint: 775,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
        {
          // screens greater than >= 1024px
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
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
     * Init Dialog/Modal
     * Dialog or modal
     * @link https://frend.co/components/dialogmodal/
     */
    let dialogElement = '.fr-dialogmodal';
    new Frdialogmodal({
      // String - Outer container selector, hook for JS init() method
      selector: dialogElement,

      // String - Modal selector, the element that represents the modal
      modalSelector: '.fr-dialogmodal-modal',

      // String - Selector for the open button
      openSelector: '.fr-dialogmodal-open',

      // String - Selector for the close button
      closeSelector: '.fr-dialogmodal-close',

      // Boolean - Switches the dialog role to alertdialog, only use this when representing an alert, error or warning
      isAlert: false,

      // String - Class name that will be added to the selector when the component has been initialised
      readyClass: 'fr-dialogmodal--is-ready',

      // String - Class name that will be added to the selector when the component is active
      activeClass: 'fr-dialogmodal--is-active',
    });

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
    let socialLinkElement = '.social-share';
    new TenUp.socialLinks({
      'target': socialLinkElement,
      'window_height': 450,
      'window_width': 625,
    });

    /*
     * Fix for `.card-single-link` elements
     * Makes the entirety of the card clickable
     * @link https://inclusive-components.design/cards/
     */
    let cards = document.querySelectorAll('.card-single-link');
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

    /*
     * Init fr-offcanvas
     * Toggleable offcanvas panel
     * @link https://frend.co/components/offcanvas/
     */
    let offCanvasElement = '.fr-offcanvas-panel';
    Froffcanvas({
      // String - Panel selector, hook for JS init() method
      selector: offCanvasElement,

      // String - Selector for the open button(s)
      openSelector: '.fr-offcanvas-open',

      // String - Selector for the close button
      closeSelector: '.fr-offcanvas-close',

      // Boolean - Prevent click events outside panel from triggering close
      preventClickOutside: false,

      // String - Class name that will be added to the selector when the component has been initialised
      readyClass: 'fr-offcanvas--is-ready',

      // String - Class name that will be added to the selector when the panel is visible
      activeClass: 'fr-offcanvas--is-active',
    });

    let offCanvasToggle = document.querySelector('.fr-offcanvas-open');
    offCanvasToggle.classList.add('is-ready');

    /*
     * Init fr-tabs
     * Accessible tab system
     * @link https://frend.co/components/tabs/
     */
    let tabsElement = '.js-fr-tabs';
    new Frtabs({
      // String - Outer container selector, hook for JS init() method
      selector: tabsElement,

      // String - List selector to transform into tablist
      tablistSelector: '.js-fr-tabs__tablist',

      // String - Containers which hold content, toggled via tabs
      tabpanelSelector: '.js-fr-tabs__panel',

      // String - Class name that will be added to the selector when the component has been initialised
      tabsReadyClass: 'fr-tabs--is-ready',
    });

    /*
     * Init Pikaday
     * A refreshing JavaScript Datepicker
     * @link https://github.com/Pikaday/Pikaday
     */
    let datePickerElement = document.getElementById('datepicker');
    var datePicker = new Pikaday({
      field: datePickerElement,
      format: 'D/M/YYYY',
      onSelect: function () {
        console.log(datePicker.toString());
      },
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
