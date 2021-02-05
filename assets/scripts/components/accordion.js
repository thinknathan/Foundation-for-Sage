import Fraccordion from 'fr-accordion';

export default function (accordionElement) {
  new Fraccordion({
    // String - Outer container selector, hook for JS init() method
    selector: accordionElement,

    // String - Accordion header elements converted to focusable, togglable elements
    headerSelector: accordionElement + '__header',

    // String - Use header id on element to tie each accordion panel to its header - see panelIdPrefix
    headerIdPrefix: 'accordion-header',

    // String - Accordion panel elements to expand/collapse
    panelSelector: accordionElement + '__panel',

    // String - Use panel id on element to tie each accordion header to its panel - see headerIdPrefix
    panelIdPrefix: 'accordion-panel',

    // Boolean - If set to false, all accordion panels will be closed on init()
    firstPanelsOpenByDefault: true,

    // Boolean - If set to false, each accordion instance will only allow a single panel to be open at a time
    multiselectable: false,

    // String - Class name that will be added to the selector when the component has been initialised
    readyClass: accordionElement + '--is-ready',

    // Integer - Duration (in milliseconds) of CSS transition when opening/closing accordion panels
    transitionLength: 250,
  });
}
