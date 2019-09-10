/*
 * Utililty to check if element is visible
 *
 * @param DOMNode  elem
 * @returns Boolean
 */
export default function(elem) {
  if (!elem) return false;
  return !!(elem.offsetWidth ||
    elem.offsetHeight ||
    elem.getClientRects().length);
}
