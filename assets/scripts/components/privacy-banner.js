import Cookies from 'js-cookie';

export default function () {
  if (!Cookies.get('privacy-is-accepted')) {
    var acceptButton = this.querySelector('#callout--privacy__close');
    this.classList.remove('callout--privacy--inactive');
    this.setAttribute('role', 'dialog');
    if (acceptButton) acceptButton.focus();
    this.addEventListener('click', function (event) {
      if (event.target.matches('#callout--privacy__more') || event.target.matches('#callout--privacy__close')) {
        Cookies.set('privacy-is-accepted', 1, {
          expires: 365
        });
        this.classList.add('callout--privacy--inactive');
      }
    });
  }
}
