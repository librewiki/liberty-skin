/* eslint-disable */
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')

module.exports = {
	entry: {
		"layout": __dirname + '/js/index.js',
		"live-recent": __dirname + '/js/live-recent.js',
		"login-request": __dirname + '/js/login-request.js'
	},
	output: {
		path: __dirname + '/dist',
		filename: '[name].js'
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				loader: 'babel-loader',
				exclude: /node_modules/
			}
		]
	},
	plugins: [
    new UglifyJsPlugin()
  ]
};
