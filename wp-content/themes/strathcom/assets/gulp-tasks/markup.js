/*jshint node: true*/
/*global require*/

var gulp = require( 'gulp' );
var livereload = require( 'gulp-livereload' );
var plumber = require( 'gulp-plumber' );
var del = require( 'del' );

var paths = require( '../config' ).paths;

// Copy HTML files into the output folder
gulp.task( 'build:html', [ 'clean:html' ], function() {
	return gulp.src( paths.html.input )
		.pipe( plumber() )
		.pipe( gulp.dest( paths.html.output ) )
		.pipe( livereload() );
 } );

// Remove pre-existing content from HTML output folder
gulp.task( 'clean:html', function() {
	del.sync( [
		paths.html.output
	] );
 } );
