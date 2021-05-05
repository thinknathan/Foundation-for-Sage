import isVisible from './isVisible';

/*
 * Loads video sources that have their URI in data-src
 * Moves data-src into src
 */
export default function (elem) {
  if (!elem) return;

  if (isVisible(elem)) {
    let children = elem.getElementsByTagName('source');
    for (let i = 0; i < children.length; ++i) {
      children[i].src = children[i].getAttribute('data-src');
    }
    // Activates loading only if the video is not already loading or ready
    if (elem.readyState < 1) elem.load();
  }
}
