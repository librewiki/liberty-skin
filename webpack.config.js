/* eslint-disable */
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')

module.exports = {
	entry: __dirname + '/js/index.js',
	output: {
		path: __dirname + '/dist',
		filename: 'bundle.js'
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
