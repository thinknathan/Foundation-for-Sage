/* ========================================================================
 * Scripts that are inlined in the head
 * Warning: jQuery is not yet loaded
 * ======================================================================== */

import '../../node_modules/fg-loadcss/src/cssrelpreload.js';

(function (document, window) {
  // Store HTML element
  var htmlTag = document.getElementsByTagName('html')[0];

  // Remove .no-js class from HTML tag
  htmlTag.classList.remove('no-js');

  // Creates a temporary jQuery object
  // that runs queued jQ commands after the real jQ loads
  /* jshint -W018 */
  if (!window.jQuery) {
    window.jQueryQ = window.jQueryQ || [];
    var jQueryQueue = function () {
      return this;
    };
    window.jQuery = function () {
      return new jQueryQueue();
    };
    window.jQuery.fn = jQueryQueue.prototype;
    window.jQuery.fn.each = function (b) {
      for (var a = 0; a < this.length; a++) {
        var c = b.call(this, a, this[a]);
        if (!0 === c) {
          return !0;
        }
        if (!1 === c) {
          return !1;
        }
      }
      return this;
    };
    window.jQuery.fn.ready = function () {
      window.jQueryQ.push(arguments);
    };
    document.addEventListener('DOMContentLoaded', function () {
      jQuery(function () {
        jQuery.each(window.jQueryQ || [], function (b, a) {
          setTimeout(function () {
            jQuery.apply(this, a);
          }, 0);
        });
      });
    }, !1);
  }

})(document, window);
