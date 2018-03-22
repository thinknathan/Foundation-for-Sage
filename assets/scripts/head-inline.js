/* ========================================================================
 * Scripts that are inlined in the head
 * Warning: jQuery is not yet loaded
 * ======================================================================== */

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

  // Creates a temporary jQuery object
  // that runs queued jQ commands after the real jQ loads
  if (!window.jQuery) {
    window.jQueryQ = window.jQueryQ || [];
    window.jQuery = function () {
      return new jQueryQueue
    };
    var jQueryQueue = function () {
      return this
    };
    window.jQuery.fn = jQueryQueue.prototype;
    window.jQuery.fn.each = function (b) {
      for (var a = 0; a < this.length; a++) {
        var c = b.call(this, a, this[a]);
        if (!0 === c) return !0;
        if (!1 === c) return !1
      }
      return this
    };
    window.jQuery.fn.ready = function () {
      window.jQueryQ.push(arguments)
    };
    document.addEventListener("DOMContentLoaded", function () {
      jQuery(function () {
        jQuery.each(window.jQueryQ || [], function (b, a) {
          setTimeout(function () {
            jQuery.apply(this, a)
          }, 0)
        })
      })
    }, !1)
  };

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
