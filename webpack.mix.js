const mix = require('laravel-mix');
const webpack = require('webpack');
require('laravel-mix-versionhash');

// Public path helper
const publicPath = path => `${mix.config.publicPath}/${path}`;

// Source path helper
const src = path => `assets/${path}`;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

// Public Path
mix.setPublicPath('./dist');

// Browsersync
mix.browserSync({
  proxy: 'http://localhost/xxx/public_html/',
  files: [
    '**/*.php',
    publicPath`(styles|scripts)/**/*.(css|js)`,
  ],
});

// Styles
mix.sass(src`styles/app.main.scss`, 'styles');

// JavaScript
mix.js(src`scripts/app.main.js`, 'scripts')
  .js(src`scripts/app.priority.js`, 'scripts');

// Assets
mix.copyDirectory(src`images`, publicPath`images`)
  .copyDirectory(src`fonts`, publicPath`fonts`);

// Ignore Pikaday.js file trying to import Moment.js
mix.webpackConfig({
  plugins: [
    new webpack.IgnorePlugin(/moment/),
  ],
});

// Don't rebase URLs in CSS
mix.options({
  processCssUrls: false,
});

if (!mix.inProduction()) {
  // Source maps when not in production.
  mix.sourceMaps();
}

if (mix.inProduction()) {
  // Hash and version files in production.
  mix.versionHash();

  // PostCSS Plugins
  mix.options({
    postCss: [
      require('postcss-discard-duplicates'),
      require('postcss-font-magician')({
        display: 'swap',
        hosted: [src`fonts`, publicPath`fonts`],
        protocol: 'https:',
      }),
    ],
  });
}
