import Frdialogmodal from 'fr-dialogmodal';

export default function (dialogElement) {
  new Frdialogmodal({
    // String - Outer container selector, hook for JS init() method
    selector: dialogElement,

    // String - Modal selector, the element that represents the modal
    modalSelector: dialogElement + '__modal',

    // String - Selector for the open button
    openSelector: dialogElement + '__open',

    // String - Selector for the close button
    closeSelector: dialogElement + '__close',

    // Boolean - Switches the dialog role to alertdialog, only use this when representing an alert, error or warning
    isAlert: false,

    // String - Class name that will be added to the selector when the component has been initialised
    readyClass: 'dialogmodal--is-ready',

    // String - Class name that will be added to the selector when the component is active
    activeClass: 'dialogmodal--is-active',
  });
}
