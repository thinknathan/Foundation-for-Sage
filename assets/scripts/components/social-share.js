export default function () {
  this.addEventListener('click', function (event) {
    if (event.target.matches('.social-share__link')) {
      event.preventDefault();
      event.stopPropagation();

      let target = event.target;
      let location = target.getAttribute('href');
      let randomNumber = Math.random() * (9999 - 1) + 1;
      let socialWindow;

      // If still no location set, bail out
      if (!location) return;

      // Open the window
      socialWindow = window.open(location, 'share-window-' + randomNumber, 'width=' + 625 + ',height=' + 450 + 'menubar=no,location=no,resizable=no,scrollbars=no,status=no');

      // Reset the opener
      socialWindow.opener = null;
    }
  });

}
