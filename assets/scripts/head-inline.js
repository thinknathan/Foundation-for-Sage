/* ========================================================================
 * Scripts that are inlined in the head
 * Warning: jQuery is not yet loaded
 * ======================================================================== */

// Insert tracking codes here



// Anonymous function where the rest of the setup happens

(function (document, window) {
  // Store HTML element
  var htmlTag = document.getElementsByTagName('html')[0];

  // Name of a webfont you want to track loading progress
  var customFont = '';

  // Remove .no-js class from HTML tag
  htmlTag.classList.remove('no-js');

  // Use FontFaceObserver to see when font is loaded
  if (customFont) {
    var fontA = new FontFaceObserver(customFont);
    fontA
      .load()
      .then(function () {
        // Remove .no-fonts class from HTML tag
        htmlTag.classList.remove('no-fonts');
      });
  }

  /*
  // Google Analytics additional setup
  // Requires Google Analytics and User ID Utility (nutil.js)
  if (window.ga && window.nUtil) {
    var uaID;

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
  }

  // Insert your tracking ID
  ga('create', 'UA-XXXXX-Y', 'auto');
  // Uncomment if using Remarketing, Demographics and Interest Reporting
  //ga('require', 'displayfeatures');
  ga('send', 'pageview');
  */

})(document, window);
