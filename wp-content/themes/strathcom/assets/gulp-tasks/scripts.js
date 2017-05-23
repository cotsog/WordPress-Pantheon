/*jshint node: true*/
/*global require*/

var gulp = require( 'gulp' );
var livereload = require( 'gulp-livereload' );
var del = require( 'del' );
var sourcemaps = require( 'gulp-sourcemaps' );
var rename = require( 'gulp-rename' );
var browserify = require( 'browserify' );
var source = require( 'vinyl-source-stream' );
var buffer = require( 'vinyl-buffer' );
var uglify = require( 'gulp-uglify' );
var gutil = require( 'gulp-util' );
var jshint = require( 'gulp-jshint' );
var jscs = require( 'gulp-jscs' );
var modernizr = require( 'gulp-modernizr' );
var concat = require( 'gulp-concat' );

var paths = require( '../config' ).paths;

// Build scripts
gulp.task( 'build:scripts', [ 'lint:scripts' ], function() {

	// Set up the browserify instance on a task basis
	var b = browserify( {
		entries: paths.scripts.input + paths.scripts.entryPoint,
		debug: true
	 } );

	return b.bundle()
		.pipe( source( paths.scripts.entryPoint ) )
		.pipe( buffer() )
		.pipe( sourcemaps.init( { loadMaps: true } ) )

				// Add transformation tasks to the pipeline here.
				.on( 'error', gutil.log )
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( paths.scripts.output ) )
		.pipe( livereload() );
 } );

// Build vendor package
gulp.task( 'build:vendor', function() {
	return gulp.src( paths.scripts.vendor )
		.pipe( concat( 'vendor.js' ) )
		.pipe( gulp.dest( paths.scripts.output ) );
 } );

// Custom Modernizr build
// Sample config: https://github.com/Modernizr/customizr#config-file
gulp.task( 'build:modernizr', function() {
	return gulp.src( paths.scripts.modernizr )
		.pipe( modernizr( 'modernizr.js', {
			options: [
				'setClasses',
				'addTest'
			],
			tests: [
				'flexbox',
				'flexboxtweener',
				'touchevents'
			],
			uglify: false
		 } ) )
		.pipe( gulp.dest( paths.scripts.output ) );
 } );

// Remove pre-existing content from JS output folder
gulp.task( 'clean:js', function() {
	del.sync( [
		paths.scripts.output
	] );
 } );

// Lint JS files
gulp.task( 'lint:scripts', function() {
	return gulp.src( paths.scripts.input + '*.js' )
		.pipe( jshint( {
			'boss': true,
			'curly': true,
			'eqeqeq': true,
			'eqnull': true,
			'es3': true,
			'expr': true,
			'immed': true,
			'noarg': true,
			'onevar': true,
			'quotmark': 'single',
			'trailing': true,
			'undef': true,
			'unused': true,
			'browser': true,
			'globals': {
				'_': false,
				'Backbone': false,
				'jQuery': false,
				'wp': false
			}
		} ) )
		.pipe( jshint.reporter( 'default' ) )
		.pipe( jscs( { fix: true } ) )
		.pipe( jscs.reporter() )
		.pipe( gulp.dest( paths.scripts.input ) );
 } );

// Uglify JS files
gulp.task( 'uglify:scripts', [ 'build:scripts', 'build:vendor', 'build:modernizr' ], function() {
	return gulp.src( paths.scripts.output + '*.js' )
		.pipe( uglify() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( paths.scripts.output ) );
 } );
