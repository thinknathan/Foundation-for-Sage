/**
 * Loads a script and executes a callback
 * @credit https://philipwalton.com/articles/loading-polyfills-only-when-needed/
 */
export default function (src, fn, context) {
  var js = document.createElement('script');
  js.src = src;
  js.onload = () => fn.call(context);
  document.head.appendChild(js);
}
