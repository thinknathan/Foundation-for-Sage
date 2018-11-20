'use strict'; // eslint-disable-line

const webpack = require('webpack');

/** dependencies used in all configs */
const CleanPlugin = require('clean-webpack-plugin'); // removes dist folder
const CopyGlobsPlugin = require('copy-globs-webpack-plugin'); // copies assets not referenced in js/css
const MiniCssExtractPlugin = require('mini-css-extract-plugin'); // writes css file to disk
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin'); // fancy console notifications
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");

/** dependencies used during optimizations */
const UglifyJsPlugin = require('uglifyjs-webpack-plugin'); // minify js

/** dependencies used for manifest/cache-busting */
const WebpackAssetsManifest = require('webpack-assets-manifest');

/** dependencies used to merge with a preset config */
const merge = require('webpack-merge');

/** optional dependencies */
const desire = require('./util/desire');
const PurgecssPlugin = desire('purgecss-webpack-plugin'); // remove unnecessary CSS
const purgecssConfig = require('./purgecss.config');
const { default: ImageminPlugin } = desire('imagemin-webpack-plugin'); // compress images

/** local dependencies */
const assetsManifestFormatter = require('./util/assetManifestsFormatter');
const config = require('./config');

const assetsFilenames = config.enabled.cacheBusting ? config.cacheBusting : '[name]';

const webpackConfig = {
  context: config.paths.assets,
  entry: config.entry,
  devtool: config.enabled.sourceMaps ? '#cheap-module-eval-source-map' : undefined,
  mode: config.env.production ? 'production' : config.env.development ? 'development' : 'none',
  output: {
    path: config.paths.dist,
    publicPath: config.publicPath,
    filename: `scripts/${assetsFilenames}.js`,
  },
  stats: {
    hash: false,
    version: false,
    timings: false,
    children: false,
    errors: false,
    errorDetails: false,
    warnings: false,
    chunks: false,
    modules: false,
    reasons: false,
    source: false,
    publicPath: false,
  },
  optimization: {
    noEmitOnErrors: config.env.production || config.enabled.watcher,
    namedModules: config.env.development,
    occurrenceOrder: config.enabled.watcher,
    splitChunks: {
      name: true,
      cacheGroups: {
        jquery: {
          test: /(jquery|jquery-migrate)\.js/,
          name: 'jquery',
          chunks: 'all',
        },
        foundation: {
          test: /foundation-sites/,
          name: 'foundation',
          chunks: 'all',
        },
      },
    },
    minimize: config.enabled.optimization,
    minimizer: [
      new UglifyJsPlugin({
        cache: true,
        parallel: true,
        sourceMap: config.enabled.sourceMaps,
        uglifyOptions: {
          ecma: 8,
          compress: {
            warnings: true,
            drop_console: true,
          },
        },
      }),
      new webpack.HashedModuleIdsPlugin(),
    ],
  },
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.(js|s?[ca]ss)$/,
        include: config.paths.assets,
        loader: 'import-glob',
      },
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: [{
          loader: 'cache-loader',
        }, {
          loader: 'babel-loader',
        }],
      },
      {
        test: /\.(sa|sc|c)ss$/,
        include: config.paths.assets,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'cache-loader',
          },
          {
            loader: 'css-loader',
            options: {
              sourceMap: config.enabled.sourceMaps,
              //importLoaders: 2,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              config: {
                path: __dirname,
                ctx: config,
              },
              sourceMap: config.enabled.sourceMaps,
            },
          },
          {
            loader: 'sass-loader',
            options: {
              implementation: require('sass'),
              sourceMap: config.enabled.sourceMaps,
              sourceComments: true,
            },
          },
        ],
      },
      {
        test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: config.paths.assets,
        loader: 'url-loader',
        options: {
          limit: 3072,
          name: `[path]${assetsFilenames}.[ext]`,
        },
      },
      {
        test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: /node_modules/,
        loader: 'url-loader',
        options: {
          limit: 3072,
          outputPath: 'vendor/',
          name: `${config.cacheBusting}.[ext]`,
        },
      },
    ],
  },
  resolve: {
    modules: [config.paths.assets, 'node_modules'],
    enforceExtension: false,
  },
  plugins: [
    new FixStyleOnlyEntriesPlugin(),
    new CleanPlugin([config.paths.dist], {
      root: config.paths.root,
      verbose: false,
    }),
    new CopyGlobsPlugin({
      pattern: config.patterns.copy,
      output: `[path]${assetsFilenames}.[ext]`,
      manifest: config.manifest,
    }),
    new MiniCssExtractPlugin({
      filename: `styles/${assetsFilenames.replace('[hash', '[contenthash')}.css`,
      chunkFilename: `styles/${assetsFilenames.replace('[name]', '[id]')}.css`,
    }),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
      Popper: 'popper.js/dist/umd/popper.js',
    }),
    new FriendlyErrorsWebpackPlugin(),
  ],
};

if (config.enabled.purgecss && PurgecssPlugin) {
  webpackConfig.optimization.minimizer.push(new PurgecssPlugin(purgecssConfig));
}

if (config.enabled.imagemin && ImageminPlugin) {
  new ImageminPlugin({
    optipng: {
      optimizationLevel: 7,
    },
    gifsicle: {
      optimizationLevel: 3,
    },
    pngquant: {
      quality: '65-90',
      speed: 4,
    },
    svgo: {
      plugins: [{
        removeUnknownsAndDefaults: false,
      }, {
        cleanupIDs: false,
      }, {
        removeViewBox: false,
      }],
    },
    disable: config.enabled.watcher,
  });
}

if (config.enabled.cacheBusting) {
  webpackConfig.plugins.push(
    new WebpackAssetsManifest({
      output: 'assets.json',
      space: 2,
      writeToDisk: true,
      assets: config.manifest,
      replacer: assetsManifestFormatter,
    })
  );
}

module.exports = merge.smartStrategy({
  'module.loaders': 'replace',
})(webpackConfig, desire(`${__dirname}/webpack.config.preset`));
