# Foundation for Sage

Sage is a WordPress starter theme with a modern development workflow.

This branch combines the structure of [Sage 8](https://github.com/roots/sage/releases/tag/8.5.4) (vanilla WP, no Laravel) with the updated workflow of [Sage 10](https://github.com/roots/sage/releases).

## Features

* Sass for stylesheets
* Modern JavaScript
* [Laravel Mix](https://github.com/JeffreyWay/laravel-mix) for compiling assets and concatenating and minifying files
* [Browsersync](http://www.browsersync.io/) for synchronized browser testing
* CSS framework: [Foundation](https://foundation.zurb.com/)

Install the [Soil](https://github.com/roots/soil) plugin to enable additional features:

* Cleaner output of `wp_head` and enqueued assets
* Cleaner HTML output of navigation menus
* Root relative URLs
* Nice search (`/search/query/`)
* Google CDN jQuery snippet from [HTML5 Boilerplate](http://html5boilerplate.com/)
* Google Analytics snippet from [HTML5 Boilerplate](http://html5boilerplate.com/)

Install the [WP-Abettor](https://github.com/thinknathan/wp-abettor) plugin to enable additional features:

* Hide default dashboard widgets on the back-end
* Add a fixed position emblem & modifies favicon to differentiate development sites from production sites
* Disable the admin bar on the front-end
* Turn off comments and related comments in the back-end interface
* Disable Yoast SEO columns for posts and pages on the back-end interface
* Set default settings for Gravity Forms: HTML5 output on & CSS output off
* Move Gravity Forms injected scripts to the footer
* Remove cruft from text when pasting into the TinyMCE editor
* Removes the back-end admin top bar from larger screens
* Adds a View Site link to the admin sidebar
* Adds a Logout link to the admin sidebar

## Requirements

Make sure all dependencies have been installed before moving on:

* [WordPress](https://wordpress.org/) >= 4.7
* [PHP](https://secure.php.net/manual/en/install.php) >= 7.1.3 (with [`php-mbstring`](https://secure.php.net/manual/en/book.mbstring.php) enabled)
* [Node.js](http://nodejs.org/) >= 8.0.0
* [Yarn](https://yarnpkg.com/en/docs/install)

## Theme installation

Clone the git repo - `git clone https://github.com/thinknathan/Foundation-for-Sage.git` and then rename the directory to the name of your theme or website.

## Theme setup

Edit `lib/setup.php` to enable or disable theme features, setup navigation menus, post thumbnail sizes, post formats, and sidebars.

## Theme development

* Run `yarn` from the theme directory to install dependencies
* Update `webpack.mix.js` with your local dev URL

### Build commands

* `yarn start` — Compile assets when file changes are made, start Browsersync session
* `yarn build` — Compile and optimize the files in your assets directory
* `yarn build:production` — Compile assets for production

## Documentation

* [Sage documentation](https://roots.io/sage/docs/)

## Contributing

Contributions are welcome from everyone. We have [contributing guidelines](https://github.com/roots/guidelines/blob/master/CONTRIBUTING.md) to help you get started.

## Sage sponsors

Help support our open-source development efforts by [becoming a patron](https://www.patreon.com/rootsdev).

<a href="https://kinsta.com/?kaid=OFDHAJIXUDIV"><img src="https://cdn.roots.io/app/uploads/kinsta.svg" alt="Kinsta" width="200" height="150"></a> <a href="https://k-m.com/"><img src="https://cdn.roots.io/app/uploads/km-digital.svg" alt="KM Digital" width="200" height="150"></a> <a href="https://www.itineris.co.uk/"><img src="https://cdn.roots.io/app/uploads/itineris.svg" alt="itineris" width="200" height="150"></a>

## Community

Keep track of development and community news.

* Participate on the [Roots Discourse](https://discourse.roots.io/)
* Follow [@rootswp on Twitter](https://twitter.com/rootswp)
* Read and subscribe to the [Roots Blog](https://roots.io/blog/)
* Subscribe to the [Roots Newsletter](https://roots.io/subscribe/)
* Listen to the [Roots Radio podcast](https://roots.io/podcast/)

## New Additions in this Fork

### Structure
* Custom SASS file structure following [Atomic Design](https://www.smashingmagazine.com/2013/08/other-interface-atomic-design-sass/) principles
* SASS file structure that loads pieces of Zurb's Foundation, allowing you to easily remove chunks of CSS you're not using

### Popular WP Plugin Integration
* Includes SASS styles for Gravity Forms to allow easy styling
* Formats Yoast SEO Breadcrumbs to use Foundation styles

### Opinionated Changes
* Uses Zurb Foundation by default
* Removes jQuery by default
* CSS is loaded async with loadCSS
* Polyfill JS loaded as needed
* Custom login page styles in `assets/styles/molecules/_login.scss`
* Functions to output images or background images with srcset and lazyloading via Lazysizes JS
