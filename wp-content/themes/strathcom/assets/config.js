/*global module*/

// Paths
module.exports = {
	paths: {
		input: 'src/**/*',
		output: 'dist/',
		styles: {
			inputFolder: 'src/scss/',
			input: 'src/scss/**/*.scss',
			inputCommon: 'src/scss/common/**/*.scss',
			inputCompiled: 'dist/css/**/*.css',
			inputMinify: [ 'dist/css/**/*.css', '!dist/css/**/*-ltie10*.css' ],
			output: 'dist/css/'
		},
		html: {
			input: 'src/html/**/*.*',
			output: 'dist/html/'
		},
		scripts: {
			input: 'src/js/',
			watch: 'src/js/**/*.js',
			entryPoint: 'main.js',
			inlined: 'inline.js',
			output: 'dist/js/',
			modernizr: 'src/js/**/*.js',
			vendor: [
				'vendor/load_css/loadCSS.js',
				'vendor/load_css/cssrelpreload.js',
				'bower_components/flexslider/jquery.flexslider.js',
				'bower_components/baguettebox.js/src/baguetteBox.js',
				'bower_components/df-visible/jquery.visible.min.js',
				'bower_components/nouislider/distribute/nouislider.min.js',
				'bower_components/iframe-resizer/js/iframeResizer.min.js'
			]
		},
		images: {
			input: 'src/img/**/*',
			output: 'dist/img/'
		},
		fonts: {
			input: [
				'src/fonts/**/*.*',
				'bower_components/components-font-awesome/fonts/**/*.*'
			],
			output: 'dist/fonts/'
		}
	},
	config: {
		sassArgs: {
			includePaths: [ 'bower_components' ],
			outputStyle: 'expanded'
		},
		autoprefixerArgs: {
			browsers: [ 'last 2 versions', 'IE 9' ],
			cascade: true,
			remove: true
		},
		minifyCSSArgs: {
			discardComments: {
				removeAll: true
			}
		}
	}
};
