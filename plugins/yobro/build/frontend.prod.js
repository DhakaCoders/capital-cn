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
// const BundleAnalyzerPlugin = require('webpack-bundle-analyzer')
// 	.BundleAnalyzerPlugin;
const paths = require('./paths');
const commonConfig = require('./base');

const ExtractTextPlugin = require('extract-text-webpack-plugin');
const ExtractFrontCss = new ExtractTextPlugin('../css/yobro-bundle-front.css');
const ExtractFrontLess = new ExtractTextPlugin(
	'../css/yobro-bundle-front-two.css'
);

module.exports = function(env) {
	return webpackMerge(commonConfig(), {
		name: 'frontend',
		entry: {
			yobro_frontend: paths.appSrc + '/js/main.js',
		},
		module: {
			rules: [
				{
					test: /\.css$/,
					use: ExtractFrontCss.extract({
						fallback: 'style-loader',
						use: 'css-loader',
					}),
				},
				{
					test: /\.less$/,
					use: ExtractFrontLess.extract({
						fallback: 'style-loader',
						use: [
							'css-loader?modules&importLoaders=2&sourceMap&localIdentName=[local]___[hash:base64:5]',
							'less-loader?outputStyle=expanded&sourceMap',
						],
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
			// new BundleAnalyzerPlugin(),
			ExtractFrontCss,
			ExtractFrontLess,
			// vendor
			new webpack.optimize.CommonsChunkPlugin({
				name: 'vendor',
				filename: 'yobro_forntend_vendor.[chunkhash:6].js',
				minChunks: function(module) {
					// this assumes your vendor imports exist in the node_modules directory
					return (
						module.context && module.context.indexOf('node_modules') !== -1
					);
				},
			}),
			new webpack.DefinePlugin({
				'process.env': {
					NODE_ENV: JSON.stringify('production'),
				},
				__CLIENT__: true,
				__SERVER__: false,
				__DEVELOPMENT__: false,
				__DEVTOOLS__: false,
				__REACT_PERF__: false,
			}),
			new webpack.LoaderOptionsPlugin({
				minimize: true,
				debug: false,
			}),
			new webpack.optimize.UglifyJsPlugin({
				beautify: false,
				mangle: {
					screw_ie8: true,
					keep_fnames: true,
				},
				compress: {
					pure_getters: true,
					unsafe: true,
					unsafe_comps: true,
					screw_ie8: true,
					warnings: false,
				},
				comments: false,
				sourceMap: true,
			}),
			new CaseSensitivePathsPlugin(),
			new WatchMissingNodeModulesPlugin(paths.appNodeModules),
			new AssetsPlugin({
				fullPath: false,
				prettyPrint: true,
				filename: './resource/frontend-assets.json',
			}),
			new notify({ title: 'Webpack', sound: 'Glass' }),
			// new OfflinePlugin({
			//   publicPath: '/wp-content/plugins/reactivepro/assets/dist/js/', // need to change that. // runtime-template
			//   AppCache: false,
			// }),
		],
	});
};
