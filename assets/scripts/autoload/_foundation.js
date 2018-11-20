import {
  Foundation,
  //CoreUtils,
  //Box,
  //onImagesLoaded,
  //Keyboard,
  //MediaQuery,
  //Motion,
  //Nest,
  //Timer,
  //Touch,
  //Triggers,
  //Abide,
  Accordion,
  //AccordionMenu,
  Drilldown,
  //Dropdown,
  DropdownMenu,
  //Equalizer,
  //Interchange,
  Magellan,
  OffCanvas,
  //Orbit,
  //ResponsiveMenu,
  //ResponsiveToggle,
  //Reveal,
  //Slider,
  SmoothScroll,
  //Sticky,
  Tabs,
  //Toggler,
  Tooltip,
  ResponsiveAccordionTabs,
} from 'foundation-sites';

/*
const $accordion = new Accordion($('.accordion'));
const $drilldown = new Drilldown($('.drilldown.menu'));
const $dropdownmenu = new DropdownMenu($('.dropdown.menu'));
const $magellan = new Magellan($('[data-magellan]'));
const $offcanvas = new OffCanvas($('.offcanvas'));
const $smoothscroll = new SmoothScroll($('[data-smooth-scroll]'));
const $tabs = new Tabs($('.tabs'));
const $tooltip = new Tooltip($('[data-tooltip]'));
const $responsiveaccordiontabs = new ResponsiveAccordionTabs($('[data-responsive-accordion-tabs]'));
*/

Foundation.plugin(Accordion, 'Accordion');
Foundation.plugin(Drilldown, 'Drilldown');
Foundation.plugin(DropdownMenu, 'DropdownMenu');
Foundation.plugin(Magellan, 'Magellan');
Foundation.plugin(OffCanvas, 'OffCanvas');
Foundation.plugin(SmoothScroll, 'SmoothScroll');
Foundation.plugin(Tabs, 'Tabs');
Foundation.plugin(Tooltip, 'Tooltip');
Foundation.plugin(ResponsiveAccordionTabs, 'ResponsiveAccordionTabs');
