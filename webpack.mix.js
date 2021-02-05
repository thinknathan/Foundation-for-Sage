// Set public path if it's something other than root
const publicPath = '/';
// Set theme name
const themeName = '';
const webpack = require('webpack');
const mix = require('laravel-mix');
            require('laravel-mix-copy-watched');

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

mix.setPublicPath('./dist')
   .webpackConfig({
      output: {
        publicPath: `${publicPath}app/themes/${themeName}/dist/`,
        chunkFilename: 'scripts/chunks/[name].[chunkhash].js'
      }
   })
   .browserSync({
      proxy: `localhost${publicPath}`,
      files: [
        '**/*.php',
        `dist/(styles|scripts)/**/*.(css|js)`,
      ],
    });

mix.sass('assets/styles/app.main.scss', 'styles')
   .sass('assets/styles/editor.scss', 'styles');

mix.js('assets/scripts/app.main.js', 'scripts');

mix.copyWatched('assets/images/**', 'dist/images')
   .copyWatched('assets/fonts/**', 'dist/fonts');

// Ignore Pikaday.js file trying to import Moment.js
mix.webpackConfig({
  plugins: [
    new webpack.IgnorePlugin({resourceRegExp: /moment/}),
  ],
});

// Don't rebase URLs in CSS
mix.options({
  processCssUrls: false,
});

// Source maps when not in production.
mix.sourceMaps(false, 'source-map');

if (mix.inProduction()) {
  // Make babel parse packages in node_modules
  mix.webpackConfig({
    module: {
      rules: [
        {
          test: /\.jsx?$/,
          exclude: /(bower_components)/,
          use: [
            {
              loader: 'babel-loader',
              options: Config.babel()
            }
          ]
        }
      ]
    }
  });
}
