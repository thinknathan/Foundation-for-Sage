import pv from 'parallax-vanilla';
    /**
     * Init vanilla parallax
     * @link https://github.com/erikengervall/parallax-vanilla
     */
    var parallaxElement = '.parallax';
    queueByElement(parallaxElement, function () {
      pv.init({
        container: {
          class: parallaxElement,
        },
        block: {
          class: parallaxElement + '__block',
        },
      });
    }, true);