/* ========================================================================
 * Scripts that are inlined in the head
 * Note: jQuery is not loaded
 * ======================================================================== */

// Remove .no-js class from HTML tag
(function (document) {
  document.getElementsByTagName('html')[0].classList.remove('no-js');
})(document);

// Preload stylesheet polyfill
// @link https://www.npmjs.com/package/fg-loadcss
import '../../node_modules/fg-loadcss/src/cssrelpreload.js';

// JS polyfill service
// @link https://cdn.polyfill.io
if (typeof Promise === 'undefined' || typeof requestAnimationFrame === 'undefined' || typeof Object.assign != 'function') {
  let scriptToInject = document.createElement('script');
  let documentHead = document.head;
  let firstScriptInHead = document.getElementsByTagName('script')[0];
  scriptToInject.type = 'text/javascript';
  scriptToInject.src = 'https://polyfill.io/v3/polyfill.min.js';
  scriptToInject.async = false;
  documentHead.insertBefore(scriptToInject, firstScriptInHead);
}
