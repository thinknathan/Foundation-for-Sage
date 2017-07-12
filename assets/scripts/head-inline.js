/* ========================================================================
 * Scripts that are inlined in the head
 * Warning: jQuery is not yet loaded
 * ======================================================================== */

// Google Analytics

(function (i, s, o, g, r, a, m) {
  i['GoogleAnalyticsObject'] = r;
  i[r] = i[r] || function () {
    (i[r].q = i[r].q || []).push(arguments)
  }, i[r].l = 1 * new Date();
  a = s.createElement(o),
    m = s.getElementsByTagName(o)[0];
  a.async = 1;
  a.src = g;
  m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

// Insert other tracking codes here


// Anonymous function where the rest of the setup happens

(function (document, window) {
  // Store HTML element
  var htmlTag = document.getElementsByTagName("html")[0];

  // Name of a webfont you want to track loading progress
  var customFont = '';

  // Remove .no-js class from HTML tag
  htmlTag.classList.remove("no-js");

  // Use FontFaceObserver to see when font is loaded
  if (customFont) {
    var fontA = new FontFaceObserver(customFont);
    fontA
      .load()
      .then(function () {
        // Remove .no-fonts class from HTML tag
        htmlTag.classList.remove("no-fonts");
      });
  }

  // Google Analytics additional setup
  // Requires Google Analytics and User ID Utility
  if (window.ga && window.nUtil) {
    var ga = window.ga;
    var nUtil = window.nUtil;
    var uaID;
  } else {
    return;
  }

  // If there's a query string in the url, use it.
  // This allows you to force a userID by setting the query:
  // http://example.com/?refID=UserIDGoesRightHere

  if (nUtil.getquery('refID')) {
    uaID = nUtil.getquery('refID');
    nUtil.set('userGaID', uaID, 360);

    // If you have a cookie set, use it
  } else if (nUtil.check('userGaID')) {
    uaID = nUtil.get('userGaID');

    // If this is their first visit, generate user ID
  } else {
    uaID = nUtil.createuid();
    nUtil.set('userGaID', uaID, 360);
  }

  // Sets up userID
  ga('set', 'userId', uaID);
  // Insert your tracking ID
  ga('create', 'UA-XXXXX-Y', 'auto');
  // Uncomment if using Remarketing, Demographics and Interest Reporting
  //ga('require', 'displayfeatures');
  ga('send', 'pageview');

})(document, window);
