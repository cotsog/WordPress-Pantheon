/*jshint node: true*/
/*global require*/

var gulp         = require( 'gulp' );
var livereload   = require( 'gulp-livereload' );
var plumber      = require( 'gulp-plumber' );
var del          = require( 'del' );
var rename       = require( 'gulp-rename' );
var flatten      = require( 'gulp-flatten' );
var sass         = require( 'gulp-sass' );
var minify       = require( 'gulp-cssnano' );
var postcss      = require( 'gulp-postcss' );
var autoprefixer = require( 'autoprefixer' );
var reporter     = require( 'postcss-reporter' );
var scss         = require( 'postcss-scss' );
var stylelint    = require( 'stylelint' );
var stylefmt     = require( 'stylefmt' );
var paths        = require( '../config' ).paths;
var config       = require( '../config' ).config;
var argv         = require( 'yargs' ).argv;
var globBase     = require( 'glob-base' );
var bless        = require( 'gulp-bless' );

// Can be added back: var sourcemaps = require( 'gulp-sourcemaps' );
var inputFiltered = paths.styles.inputFolder;
var activeTheme = argv.s;
if ( activeTheme ) {
	console.log( activeTheme );
	inputFiltered += activeTheme;
}
inputFiltered += '/**/*.scss';

// Process and lint Sass files
gulp.task( 'build:styles', [ 'clean:css' ], function() {
	return gulp.src( [ paths.styles.inputCommon, inputFiltered ], { base: globBase( paths.styles.input ).base } )
		.pipe( plumber() )
		.pipe( sass( config.sassArgs ).on( 'error', sass.logError ) )
		.pipe( rename( function( path ) {
			if ( -1 !== path.dirname.indexOf( 'theme' ) ) {
				path.basename += '-' + path.dirname;
			}
			return path;
		} ) )
		.pipe( flatten() )
		.pipe( postcss( [
			autoprefixer( config.autoprefixerArgs )
		] ) )
		.pipe( gulp.dest( paths.styles.output ) )
		.pipe( livereload() );
 } );

// Remove pre-existing content from CSS output folder
gulp.task( 'clean:css', function() {
	del.sync( [
		paths.styles.output
	] );
 } );

gulp.task( 'format:styles', function() {
	return gulp.src( paths.styles.input )
		.pipe( postcss( [
			stylefmt()
			], {
				syntax: scss
			} ) )
		.pipe( postcss( [
			stylelint(),
			reporter( { clearMessages: true } )
		], {
			syntax: scss
		} ) )
		.pipe( gulp.dest( paths.styles.inputFolder ) );
});

gulp.task( 'bless:styles', [ 'build:styles' ], function() {
	return gulp.src( paths.styles.inputCompiled )
		.pipe( plumber() )
		.pipe( rename( { suffix: '-ltie10' } ) )
		.pipe( bless( {
			suffix: '-blessed'
		} ) )
		.pipe( gulp.dest( paths.styles.output ) );
} );

// Minify CSS files
gulp.task( 'minify:styles', [ 'format:styles', 'bless:styles' ], function() {
	return gulp.src( paths.styles.inputMinify )
		.pipe( plumber() )
		.pipe( minify( config.minifyCSSArgs ) )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( paths.styles.output ) );
 } );
