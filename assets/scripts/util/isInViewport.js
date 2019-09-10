/*
 * Utililty to check if element is inside viewport
 *
 * @param DOMNode  elem
 * @returns Boolean
 */
export default function(elem) {
  if (!elem) return false;
  var bounding = elem.getBoundingClientRect();
  return (
    bounding.top >= 0 &&
    bounding.left >= 0 &&
    bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    bounding.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}
