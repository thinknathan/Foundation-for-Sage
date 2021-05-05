/*
 * Apply function to elements.
 *
 * @param string   query  Elements to select.
 * @param Function fn   Function to run.
 */
export default function(query, fn) {
  let queryAll = document.querySelectorAll(query);
  if (queryAll) {
    for (let i = 0; i < queryAll.length; ++i) {
      fn.call(queryAll[i]);
    }
  }
}
