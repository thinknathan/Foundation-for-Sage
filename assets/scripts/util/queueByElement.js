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
import 'scroll-watcher';

export default function (elemQuery, fn, singular) {
  let init = function (elem) {
    if (isVisible(elem) && isInViewport(elem)) {
      // Element is in viewport, so activate it
      fn.call(elem);
      //console.log('INSTANT: ' + fn.toString().slice(0, 60) );
    } else {
      let scroll = new ScrollWatcher().watch(elem);

      // Element is off-screen, so add it to the lazy queue
      let functionInQueue = makeIdleGetter(() => {
        // turn off scroll watcher
        scroll.off('enter');
        // run function
        fn.call(elem);
        //console.log('RUN from queue: ' + fn.toString().slice(0, 60) );
      });
      //console.log('QUEUED makeIdleGetter: ' + fn.toString().slice(0, 60) );

      // Activate it immediately if it's scrolled into view
      scroll
        .once('enter', function () {
          //console.log('SCROLL called: ' + fn.toString().slice(0, 60) );
          functionInQueue();
        });
    }
  }

  if (singular) {
    let elem = document.querySelector(elemQuery);
    if (elem) {
      init(elem);
    }
  } else {
    forEach(elemQuery, function () {
      init(this);
    });
  }
}
