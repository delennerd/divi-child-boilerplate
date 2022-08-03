let mix = require("laravel-mix");
// require('laravel-mix-copy-watched');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

let webpackConfig = {
	module: {},
	devtool: false,
	optimization: {
		minimize: false
	},
};

mix.options({
	processCssUrls: false,
});

mix.js("src/js/scripts.js", "assets/js/scripts.js")
mix.sass("src/sass/app.scss", "assets/css/app.css")

mix.copy("src/img", "assets/img")
	.copy("src/fonts", "assets/fonts");

// if (!mix.inProduction()) {
// 	webpackConfig.devtool = "inline-source-map";
// }

mix.webpackConfig(webpackConfig);