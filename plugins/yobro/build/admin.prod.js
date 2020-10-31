/* eslint-disable */
const autoprefixer = require('autoprefixer');
const webpack = require('webpack');
const webpackMerge = require('webpack-merge');
const notify = require('webpack-notifier');
const WebpackMd5Hash = require('webpack-md5-hash');
const AssetsPlugin = require('assets-webpack-plugin');
const OfflinePlugin = require('offline-plugin');
const SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');
const CaseSensitivePathsPlugin = require('case-sensitive-paths-webpack-plugin');
const WatchMissingNodeModulesPlugin = require('react-dev-utils/WatchMissingNodeModulesPlugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const paths = require('./paths');
const commonConfig = require('./base');

const ExtractAdminCss = new ExtractTextPlugin('../css/scholar-bundle-admin.css');
const ExtractAdminLess = new ExtractTextPlugin('../css/scholar-bundle-admin-two.css');


module.exports = function(env) {
  return webpackMerge(commonConfig(), {
    name: 'admin',
    entry: {
      'scholar_form_builder'                : paths.appSrc + '/form-builder/form-builder.js',
      'scholar_dynamic_page_settings'       : paths.appSrc + '/generator/page/dynamicPageGenerator.js',
      'scholar_taxonomy_generator'          : paths.appSrc + '/generator/taxonomy/taxonomyGenerator.js',
      'scholar_term_meta_generator_builder' : paths.appSrc + '/generator/termmeta/termMetaGeneratorBuilder.js',
      'scholar_metabox_builder'             : paths.appSrc + '/generator/metabox/metaboxBuilder.js',
      'scholar_post_type_builder'           : paths.appSrc + '/generator/post-type/postTypeBuilder.js',
      'scholar_template_settings'           : paths.appSrc + '/generator/template/templateGenerator.js',
      'scholar_gateway_plan'                : paths.appSrc + '/payment/plan/getGatewayPlanId.js',
      'scholar_payment_plan_restrictions'   : paths.appSrc + '/payment/plan/paymentPlanRestrictions.js',
      'scholar_payment_settings'            : paths.appSrc + '/payment/settings.js',
      'scholar_metabox_preview'             : paths.appSrc + '/meta-preview/metaboxPreview.js',
      'scholar_term_meta_preview'           : paths.appSrc + '/meta-preview/termMetaGeneratorPreview.js',
    },
    module: {
      rules:[
        {
          test: /\.css$/,
          use: ExtractAdminCss.extract({
            fallback: 'style-loader',
            use: 'css-loader'
          }),
        },
        {
          test: /\.less$/,
          use: ExtractAdminLess.extract({
            fallback: 'style-loader',
            use: [
              'css-loader?modules&importLoaders=2&sourceMap&localIdentName=[local]___[hash:base64:5]',
              'less-loader?outputStyle=expanded&sourceMap',
            ]
          }),
        },
      ],
    },
    output: {
      path: paths.appDest,
      filename: '[name]_[chunkhash:6].js',
      chunkFilename: '[name].[chunkhash:6].chunk.js',
    },
    plugins: [
      new WebpackMd5Hash(),
      ExtractAdminCss,
      ExtractAdminLess,
      new webpack.DefinePlugin({
        'process.env': {
          NODE_ENV: JSON.stringify('production'),
        },
        __CLIENT__: true,
        __SERVER__: false,
        __DEVELOPMENT__: false,
        __DEVTOOLS__: false,
        __REACT_PERF__: false
      }),
      new webpack.LoaderOptionsPlugin({
          minimize: true,
          debug: false
      }),
      new webpack.optimize.UglifyJsPlugin({
          beautify: false,
          mangle: {
              screw_ie8: true,
              keep_fnames: true
          },
          compress: {
            pure_getters: true,
            unsafe: true,
            unsafe_comps: true,
            screw_ie8: true,
            warnings: false
          },
          comments: false,
          sourceMap: true
      }),
      new CaseSensitivePathsPlugin(),
      new WatchMissingNodeModulesPlugin(paths.appNodeModules),
      new AssetsPlugin({ fullPath: false, prettyPrint: true, filename: './resource/admin-assets.json'}),
      // new OfflinePlugin({
      //   publicPath: '/wp-content/plugins/reactivepro/assets/dist/js/', // need to change that. // runtime-template
      //   AppCache: false,
      // }),
    ]
  });
}
