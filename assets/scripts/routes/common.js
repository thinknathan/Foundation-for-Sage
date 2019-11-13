import Cookies from 'js-cookie';
import AOS from 'aos';
import Rellax from 'rellax';
import Headroom from 'headroom.js';
import Glider from 'glider-js';
import Fraccordion from 'fr-accordion';
import Tobi from 'rqrauhvmra__tobi';
import Frdialogmodal from 'fr-dialogmodal';
import stickybits from 'stickybits';
import MetisMenu from 'metismenujs';
import Froffcanvas from 'fr-offcanvas';
import Frtabs from 'fr-tabs';
import Pikaday from 'pikaday';
import prefersReducedMotion from '../util/prefersReducedMotion.js';
import queueByElement from '../util/queueByElement.js';
//import delegateListener from '../util/delegateListener.js';
//import forEach from '../util/forEach.js';

export default {
  init() {
    // Motion and defaults
    let sliderDuration = 1;
    if (prefersReducedMotion()) {
      sliderDuration = 0;
    }


    /**
     * Init Privacy Callout
     */
    queueByElement('#callout--privacy', function () {
      if (!Cookies.get('privacy-is-accepted')) {
        var acceptButton = this.querySelector('#callout--privacy__close');
        this.classList.remove('callout--privacy--inactive');
        this.setAttribute('role', 'dialog');
        if (acceptButton) acceptButton.focus();
        this.addEventListener('click', function (event) {
          if (event.target.matches('#callout--privacy__more') || event.target.matches('#callout--privacy__close')) {
            Cookies.set('privacy-is-accepted', 1, {
              expires: 365
            });
            this.classList.add('callout--privacy--inactive');
          }
        });
      }
    }, true);


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
    var headroomElement = '.header--site';
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

      this.addEventListener('click', function (event) {
        if (event.target.matches(accordionElement + '__header')) {
          refreshRevealedElements();
        }
      });
    });


    /*
     * Init Tobi
     * Lightbox, light-weight and accessible
     * @link https://github.com/rqrauhvmra/Tobi
     */
    var lightboxElement = '.lightbox';
    queueByElement(lightboxElement, function () {
      new Tobi();
    });


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
    // Stick header to the top
    var stickyElementTop = '.header--site';
    queueByElement(stickyElementTop, function () {
      stickybits(stickyElementTop);
    });

    // Stick navbar to the bottom
    var stickyElementBottom = '.nav--navbar';
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

      this.addEventListener('click', function (event) {
        if (event.target.matches(tabsElement + '__tab')) {
          refreshRevealedElements();
        }
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


    /*
     * Init Social Share
     * @link https://10up.github.io/wp-component-library/component/social-links/index.html
     * @license MIT
     * @copyright 10up
     */
    var shareContainer = '.social-share';
    queueByElement(shareContainer, function () {
      this.addEventListener('click', function (event) {
        if (event.target.matches('.social-share__link')) {
          event.preventDefault();
          event.stopPropagation();

          var target = event.target;
          var location = target.getAttribute('href');
          var randomNumber = Math.random() * (9999 - 1) + 1;
          var socialWindow;

          // If still no location set, bail out
          if (!location) return;

          // Open the window
          socialWindow = window.open(location, 'share-window-' + randomNumber, 'width=' + 625 + ',height=' + 450 + 'menubar=no,location=no,resizable=no,scrollbars=no,status=no');

          // Reset the opener
          socialWindow.opener = null;
        }
      });
    });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
