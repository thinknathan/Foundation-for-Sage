// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import ready from './util/ready';
import browserSupportsAllFeatures from './util/browserSupportsAllFeatures';
import loadScript from './util/loadScript';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
});

// Load Events
ready(() => browserSupportsAllFeatures() ? routes.loadEvents() : loadScript('https://polyfill.io/v3/polyfill.min.js', routes.loadEvents, routes) );
