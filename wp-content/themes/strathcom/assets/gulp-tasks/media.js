/*jshint node: true*/
/*global require*/

var gulp = require( 'gulp' );
var livereload = require( 'gulp-livereload' );
var plumber = require( 'gulp-plumber' );
var del = require( 'del' );
var imagemin = require( 'gulp-imagemin' );
var pngquant = require( 'imagemin-pngquant' );

var paths = require( '../config' ).paths;

// Copy image files into output folder
gulp.task( 'build:images', [ 'clean:images' ], function() {
	return gulp.src( paths.images.input )
		.pipe( plumber() )
		.pipe( gulp.dest( paths.images.output ) )
		.pipe( livereload() );
 } );

// Compress Images
gulp.task( 'minify:images', function() {
	return gulp.src( paths.images.input )
		.pipe( imagemin( {
      progressive: true,
      use: [pngquant()]
 } ) )
    .pipe( gulp.dest( paths.images.output ) );
 } );

// Remove pre-existing content from images output folder
gulp.task( 'clean:images', function() {
	del.sync( [
		paths.images.output
	] );
 } );
