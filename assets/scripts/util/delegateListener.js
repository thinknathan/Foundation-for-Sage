/*
 * Add event listener to delegate.
 *
 * @param string   elem         Element(s) to select.
 * @param string   delegate     Element(s) to delegate.
 * @param string   eventType    Type of event to listen for.
 * @param Function func         Function to run when element clicked.
 */
export default function(elem, delegate, eventType, fn) {
  let delegateElem = document.querySelector(delegate);
  if (delegateElem) {
    delegateElem.addEventListener(eventType, function (event) {
      if (event.target.matches(elem)) {
        fn.call(event.target, event);
      }
    });
  }
}
