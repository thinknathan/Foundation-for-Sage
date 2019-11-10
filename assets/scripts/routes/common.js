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
import queueByElement from '../util/queueByElement.js';
import forEach from '../util/forEach.js';

export default {
  init() {
    // Motion and defaults
    let sliderDuration = 1;
    if (prefersReducedMotion()) {
      sliderDuration = 0;
    }


    /**
     * Init AOS
     * Animations on scroll
     * @link https://michalsnik.github.io/aos/
     */
    AOS.init({
      easing: 'ease-in',
    });


    /**
     * Init Relax
     * Parallax effects
     * @link https://github.com/dixonandmoe/rellax
     */
    var rellaxElement = '.rellax';
    queueByElement(rellaxElement, function () {
      new Rellax(this, {
        speed: -2,
        center: false,
        wrapper: null,
        round: true,
        vertical: true,
        horizontal: false,
      });
    });


    /**
     * Init Headroom
     * Hide your header until you need it
     * @link https://wicky.nillia.ms/headroom.js/
     */
    var headroomElement = '.headroom';
    queueByElement(headroomElement, function () {
      let headroom = new Headroom(this, {
        offset: 300,
        // scroll tolerance in px before state changes
        tolerance: 6,
      });
      headroom.init();
    });


    /**
     * Init MetisMenu navigation
     * Dropdown menu
     * @link https://github.com/onokumus/metismenujs
     */
    var navigationElement = '#menu--primary';
    queueByElement(navigationElement, function () {
      var mm1 = new MetisMenu(navigationElement).on("shown.metisMenu", function (event) {
        window.addEventListener("click", function mmClick1(e) {
          if (!event.target.contains(e.target)) {
            mm1.hide(event.detail.shownElement);
            window.removeEventListener("click", mmClick1);
          }
        });
      });
    });

    var navigationOffcanvasElement = '#menu--offcanvas';
    queueByElement(navigationOffcanvasElement, function () {
      new MetisMenu(navigationOffcanvasElement);
    });


    /**
     * Init Glider.js
     * Carousel, fast and accessible
     * @link https://nickpiscitelli.github.io/Glider.js/
     */
    var carousels = [];
    var carouselElement = '.carousel';
    queueByElement(carouselElement, function () {
      let dotsEle = this.querySelector('.carousel__dots');
      let prevEle = this.querySelector('.carousel__control--prev');
      let nextEle = this.querySelector('.carousel__control--next');
      let trackEle = this.querySelector('.carousel__track');
      let options = {
        // Mobile-first defaults
        slidesToShow: 1.2,
        slidesToScroll: 1,
        scrollLock: true,
        duration: sliderDuration,
        dots: dotsEle,
        arrows: {
          prev: prevEle,
          next: nextEle,
        },
        responsive: [
          {
            // screens greater than >= 775px
            breakpoint: 775,
            settings: {
              slidesToShow: 2.5,
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
      };
      carousels.push(new Glider(trackEle, options));
      this.classList.remove('carousel--load');
      this.classList.add('carousel--loaded');
    })


    /*
     * Utility function to refresh elements
     * when they come into view (eg. via switching tabs)
     */
    var refreshRevealedElements = function () {
      if (carousels) {
        for (let j = 0; j < carousels.length; ++j) {
          carousels[j].refresh(false);
        }
      }
    }


    /*
     * Init fr-accordion
     * Accordion, lightweight and accessible
     * @link https://frend.co/components/accordion/
     */
    var accordionElement = '.accordion';
    queueByElement(accordionElement, function () {
      new Fraccordion({
        // String - Outer container selector, hook for JS init() method
        selector: accordionElement,

        // String - Accordion header elements converted to focusable, togglable elements
        headerSelector: accordionElement + '__header',

        // String - Use header id on element to tie each accordion panel to its header - see panelIdPrefix
        headerIdPrefix: 'accordion-header',

        // String - Accordion panel elements to expand/collapse
        panelSelector: accordionElement + '__panel',

        // String - Use panel id on element to tie each accordion header to its panel - see headerIdPrefix
        panelIdPrefix: 'accordion-panel',

        // Boolean - If set to false, all accordion panels will be closed on init()
        firstPanelsOpenByDefault: true,

        // Boolean - If set to false, each accordion instance will only allow a single panel to be open at a time
        multiselectable: false,

        // String - Class name that will be added to the selector when the component has been initialised
        readyClass: accordionElement + '--is-ready',

        // Integer - Duration (in milliseconds) of CSS transition when opening/closing accordion panels
        transitionLength: 250,
      });
      let headers = this.querySelectorAll(accordionElement + '__header');
      [].forEach.call(headers, header => {
        header.addEventListener('click', refreshRevealedElements);
      });
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
    var dialogElement = '.dialogmodal';
    queueByElement(dialogElement, function () {
      new Frdialogmodal({
        // String - Outer container selector, hook for JS init() method
        selector: dialogElement,

        // String - Modal selector, the element that represents the modal
        modalSelector: dialogElement + '__modal',

        // String - Selector for the open button
        openSelector: dialogElement + '__open',

        // String - Selector for the close button
        closeSelector: dialogElement + '__close',

        // Boolean - Switches the dialog role to alertdialog, only use this when representing an alert, error or warning
        isAlert: false,

        // String - Class name that will be added to the selector when the component has been initialised
        readyClass: 'dialogmodal--is-ready',

        // String - Class name that will be added to the selector when the component is active
        activeClass: 'dialogmodal--is-active',
      });
    });


    /*
     * Init StickyBits
     * Polyfill for position: sticky
     * @link https://dollarshaveclub.github.io/stickybits/
     */
    var stickyElementTop = '.stick-to-top';
    queueByElement(stickyElementTop, function () {
      stickybits(stickyElementTop);
    });

    var stickyElementBottom = '.stick-to-bottom';
    queueByElement(stickyElementBottom, function () {
      stickybits(stickyElementBottom, {
        verticalPosition: 'bottom',
      });
    });


    /*
     * Init Social Links
     * Popup for social share buttons
     * @link https://10up.github.io/wp-component-library/component/social-links/index.html
     */
    var socialLinkElement = '.social-share';
    queueByElement(socialLinkElement, function () {
      new TenUp.socialLinks({
        'target': socialLinkElement,
        'window_height': 450,
        'window_width': 625,
      });
    });


    /*
     * Fix for `.card-single-link` elements
     * Makes the entirety of the card clickable
     * @link https://inclusive-components.design/cards/
     */
    var cards = '.card--single-link';
    queueByElement(cards, function () {
      let down, up, link = this.querySelector('h2 a');
      this.onmousedown = () => down = +new Date();
      this.onmouseup = () => {
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
    var offCanvasElement = '.offcanvas';
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


    /*
     * Init fr-tabs
     * Accessible tab system
     * @link https://frend.co/components/tabs/
     */
    var tabsElement = '.tabs';
    queueByElement(tabsElement, function () {
      new Frtabs({
        // String - Outer container selector, hook for JS init() method
        selector: tabsElement,

        // String - List selector to transform into tablist
        tablistSelector: tabsElement + '__tablist',

        // String - Containers which hold content, toggled via tabs
        tabpanelSelector: tabsElement + '__panel',

        // String - Class name that will be added to the selector when the component has been initialised
        tabsReadyClass: 'tabs--is-ready',
      });
    });


    /*
     * Init Pikaday
     * A refreshing JavaScript Datepicker
     * @link https://github.com/Pikaday/Pikaday
     */
    var datePickerElement = '#datepicker';
    queueByElement(datePickerElement, function () {
      var datePicker = new Pikaday({
        field: this,
        format: 'D/M/YYYY',
        onSelect: function () {
          console.log(datePicker.toString());
        },
      });
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
