/*
 * Remove .no-js class from HTML tag
 */
(function (document) {
  document.getElementsByTagName('html')[0].classList.remove('no-js');
})(document);

/*
 * Preload stylesheet polyfill
 * @link https://www.npmjs.com/package/fg-loadcss
 */
import '../../node_modules/fg-loadcss/src/cssrelpreload.js';

/*
 * Lazysizes lazy-loading library
 * @link https://github.com/aFarkas/lazysizes
 */
import '../../node_modules/lazysizes/lazysizes.js';
import '../../node_modules/lazysizes/plugins/respimg/ls.respimg.js';
import '../../node_modules/lazysizes/plugins/bgset/ls.bgset.js';

lazySizes.cfg.loadingClass = 'is-lazyloading';
lazySizes.cfg.loadedClass = 'is-lazyloaded';
