import Frtabs from 'fr-tabs';

export default function (tabsElement) {
  new Frtabs({
    // String - Outer container selector, hook for JS init() method
    selector: tabsElement,

    // String - List selector to transform into tablist
    tablistSelector: tabsElement + '__tablist',

    // String - Containers which hold content, toggled via tabs
    tabpanelSelector: tabsElement + '__panel',

    // String - Class name that will be added to the selector when the component has been initialised
    tabsReadyClass: 'tabs--is-ready',
  });
}
