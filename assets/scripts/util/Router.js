import camelCase from './camelCase';

/**
 * DOM-based Routing
 *
 * Based on {@link http://goo.gl/EUTi53|Markup-based Unobtrusive Comprehensive DOM-ready Execution} by Paul Irish
 *
 * The routing fires all common scripts, followed by the page specific scripts.
 * Add additional events for more control over timing e.g. a finalize event
 */
class Router {

  /**
   * Create a new Router
   * @param {Object} routes
   */
  constructor(routes) {
    this.routes = routes;
  }

  /**
   * Automatically load and fire Router events
   *
   * Events are fired in the following order:
   *  * page-specific init
   *  * page-specific finalize
   */
  loadEvents() {
    let context = this;
    // Fire page-specific init JS, and then finalize JS
    document.body.className
      .toLowerCase()
      .replace(/-/g, '_')
      .split(/\s+/)
      .map(camelCase)
      .forEach((className) => {
        if (context.routes.includes(className)) {
          /* jshint ignore:start */
          import('../routes/' + className).then(dynamicImport => {
            if (dynamicImport.default.init) dynamicImport.default.init();
            if (dynamicImport.default.finalize) dynamicImport.default.finalize();
          });
          /* jshint ignore:end */
        }
      });
  }
}

export default Router;
