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
})(document, window);
