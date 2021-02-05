// import local dependencies
import Router from './util/Router';
import ready from './util/ready';
import browserSupportsAllFeatures from './util/browserSupportsAllFeatures';
import loadScript from './util/loadScript';
import common from './routes/common';

/** Populate Router instance with DOM routes */
const routes = new Router([
  // Home page
  'home',
  // About Us page, note the change from about-us to aboutUs.
  'aboutUs',
]);

// Event to start everything
const init = () => {
  common.init();
  common.finalize();
  routes.loadEvents();
};

// Load Events on ready
ready(() => {
  document.getElementsByTagName('html')[0].classList.remove('no-js');
  if (browserSupportsAllFeatures()) {
    init();
  } else {
    loadScript('https://polyfill.io/v3/polyfill.min.js', init, routes);
  }
});
