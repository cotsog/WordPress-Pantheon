/*jshint node: true*/
/*global require*/

var gulp = require( 'gulp' );
var plumber = require( 'gulp-plumber' );
var del = require( 'del' );

var paths = require( '../config' ).paths;

// Copy Fonts into the output folder
gulp.task( 'build:fonts', [ 'clean:fonts' ], function() {
	return gulp.src( paths.fonts.input )
		.pipe( plumber() )
		.pipe( gulp.dest( paths.fonts.output ) );
 } );

// Remove pre-existing content from fonts output folder
gulp.task( 'clean:fonts', function() {
	del.sync( [
		paths.fonts.output
	] );
 } );
