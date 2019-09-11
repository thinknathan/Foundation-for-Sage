/**
 * Conditionally adds function to a lazy queue, or runs it immediately.
 *
 * Give it a DOM element to check and a function to run.
 * Set singular to true for it to only apply to 1 element, otherwise it loops through all queried elements.
 *
 * 1. Checks if element is visible and in viewport. If so, runs function.
 * 2. If not, adds it to an idle queue. Once browser is idle, runs function.
 * 3. Create a scrollwatcher to watch for element entering viewport.
 * 4. If the element is scrolled into view, run function.
 */

import forEach from './forEach';
import isVisible from './isVisible';
import isInViewport from './isInViewport';
import makeIdleGetter from 'idle-until-urgent';
import ScrollWatcher from 'scroll-watcher';

export default function (elemQuery, fn, singular) {
  var init = function (elem) {
    if (isVisible(elem) && isInViewport(elem)) {
      // Element is in viewport, so activate it
      //console.log('PASSED isInViewport + isVisible: ' + fn);
      fn.call(elem);
    } else {
      // Element is off-screen, so add it to the lazy queue
      var functionInQueue = makeIdleGetter(() => fn.call(elem));
      //console.log('QUEUED ' + fn + ' to makeIdleGetter');

      // Activate it immediately if it's scrolled into view
      var scroll = new ScrollWatcher();
      scroll
        .watch(elem)
        .once("enter", function () {
          if (isVisible(elem)) {
            functionInQueue();
            //console.log('SCROLL called functionInQueue: ' + fn);
          }
        });
    }
  }

  if (singular) {
    var elem = document.querySelector(elemQuery);
    if (elem) {
      init(elem);
    }
  } else {
    forEach(elemQuery, function () {
      init(this);
    })
  }
}
