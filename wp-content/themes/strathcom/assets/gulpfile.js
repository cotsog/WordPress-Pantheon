/*ignore jslint start*/
/* jshint ignore:start */
/*jshint -W117 */
/*jshint node: true, unused: false*/
/*global require*/

var gulp = require( 'gulp' );
var requireDir = require( 'require-dir' );
var livereload = require( 'gulp-livereload' );
var fs = require('fs');
var taskListing = require('gulp-task-listing');

var paths = require( './config' ).paths;

requireDir( './gulp-tasks' );

// Add a task to render the output
gulp.task('help', taskListing);

// Remove pre-existing content from output and test folders
gulp.task( 'clean:dist', [
	'clean:css',
	'clean:js',
	'clean:images',
	'clean:html',
	'clean:fonts'
] );

// Compile files
gulp.task( 'compile', function() {
	return gulp.start(
		'build:html',
		'build:fonts',
		'build:styles',
		'build:color-scheme',
		'compile:js',
		'build:images',
		'cache-buster'
	);
} );

// Recompile scripts
gulp.task( 'compile:js', [ 'clean:js' ], function() {
	return gulp.start(
		'build:scripts',
		'build:vendor',
		'build:modernizr'
	);
} );

// Minify files
gulp.task( 'minify', [
	'uglify:scripts',
	'minify:styles'
] );

// Compile files for production ( default )
gulp.task( 'default', [ 'compile' ], function() {
	return gulp.start(
		'minify'
	);
} );

// Compile files for development ( watch for changes )
gulp.task( 'watch', function() {
	return gulp.start(
		'listen'
	);
} );

// https://github.com/sindresorhus/gulp-rev
// https://www.npmjs.com/package/gulp-hash
gulp.task('cache-buster', function(cb){
	//new Date().getTime()
	fs.writeFile( '../../../../wp-cache-buster.php', "<?php define( 'SMI_CACHE_BUSTER', " + new Date().getTime() + " );\n", cb );
});

// Listen for file changes
gulp.task( 'listen', function() {
	livereload.listen();
	gulp.watch( paths.html.input ).on( 'change', function() {
		gulp.start( 'build:html' );
	} );
	gulp.watch( paths.fonts.input ).on( 'change', function() {
		gulp.start( 'build:fonts' );
	} );
	gulp.watch( paths.styles.input ).on( 'change', function() {
		gulp.start( 'build:styles' );
		gulp.start( 'build:color-scheme' );
	} );
	gulp.watch( paths.scripts.watch ).on( 'change', function() {
		gulp.start( 'build:scripts' );
	} );
	gulp.watch( paths.scripts.vendor ).on( 'change', function() {
		gulp.start( 'build:vendor' );
	} );
	gulp.watch( paths.images.input ).on( 'change', function() {
		gulp.start( 'build:images' );
	} );
} );
/* jshint ignore:end */
/*ignore jslint end*/
