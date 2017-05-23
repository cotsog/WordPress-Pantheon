/*jshint node: true*/
/*global require*/

var gulp         = require( 'gulp' );
var concat       = require( 'gulp-concat-util' );
var replace      = require( 'gulp-string-replace' );
var plumber      = require( 'gulp-plumber' );
var rename       = require( 'gulp-rename' );
var flatten      = require( 'gulp-flatten' );
var sass         = require( 'gulp-sass' );
var minify       = require( 'gulp-cssnano' );
var postcss      = require( 'gulp-postcss' );
var autoprefixer = require( 'autoprefixer' );
var paths        = require( '../config' ).paths;
var config       = require( '../config' ).config;
var argv         = require( 'yargs' ).argv;
var globBase     = require( 'glob-base' );

/**
 * Default options for `gulp-string-replace` task.
 * @type {object}
 */
var replaceOptions = {
	logs: {
		enabled: false
	}
};

/**
 * Determine active theme name base on cmd arguments.
 * @returns {string|null} Active theme name or null.
 */
var activeTheme = ( function getActiveTheme() {
	var activeTheme = argv.s;

	if ( ! activeTheme || '' === activeTheme ) {
		activeTheme = null;
	}

	return activeTheme;
} )();

/**
 * Determine actual color scheme stylesheet path.
 * @returns {string}
 */
var colorSchemePath = ( function getColorSchemePath() {
	var colorSchemeSrc = paths.styles.inputFolder;

	if ( activeTheme ) {
		console.log( 'Compiling color scheme of \'' + activeTheme + '\' theme only.' );
		colorSchemeSrc += activeTheme + '/';
	} else {
		console.log( 'Compiling color scheme of all excising themes.' );
	}
	colorSchemeSrc += '**/color-scheme.scss';

	return colorSchemeSrc;
} )();

/**
 * Build color scheme meta PHP array based on SCSS file.
 */
gulp.task( 'build:color-scheme-meta', function() {
	var fileHeader                  = '<?php\nfunction strathcom_get_color_scheme() {\n\treturn array(\n',
		fileFooter                  = '\t);\n}\n',
		matchColorMetaLine          = /^\s*\$([a-zA-Z0-9\-_]*):\s*((?:#(?:[0-9a-fA-F]{3}){1,2})|\$(?:[a-zA-Z0-9\-_]*))\s*;\s*\/\/\s*en:\s*('(?:[^'\\]|\\.)*')\s*,\s*fr:\s*('(?:[^'\\]|\\.)*')\s*/gm,
		matchIrrelevantHeaderFooter = /^(?!\t*array)[\n\r]?.*[\n\r]?/gm,
		stream, buildColorMetaArray;

	/**
	 * Return PHP array with color meta information.
	 * Used as RegExp replace callback function.
	 *
	 * @param {string} match  The matched string.
	 * @param {string} name  Color slug.
	 * @param {string} defaultValue  Default color HEX value.
	 * @param {string} labelEn  English color label. Used in Customizer.
	 * @param {string} labelFr  French color label. Used in Customizer.
	 * @returns {string}
	 */
	buildColorMetaArray = function( match, name, defaultValue, labelEn, labelFr ) {
		return '\t\tarray( \'name\' => \'' + name + '\', \'default\' => \'' + defaultValue + '\', \'label_en\' => ' + labelEn + ', \'label_fr\' => ' + labelFr + ' ),\n';
	};

	stream = gulp
		.src( colorSchemePath, {
			base: globBase( paths.styles.input ).base
		} )
		.pipe( plumber() )
		.pipe( replace( matchColorMetaLine, buildColorMetaArray, replaceOptions ) )
		.pipe( replace( matchIrrelevantHeaderFooter, '', replaceOptions ) )
		.pipe( concat.header( fileHeader ) )
		.pipe( concat.footer( fileFooter ) )
		.pipe( rename( function( path ) {
			path.extname = '.php';
			path.basename = path.basename + '-meta';
			if ( -1 !== path.dirname.indexOf( 'theme' ) ) {
				path.basename = path.basename + '-' + path.dirname;
			}
			return path;
		} ) )
		.pipe( flatten() )
		.pipe( gulp.dest( paths.styles.output ) );

	return stream;
} );

/**
 * Build color scheme stylesheet PHP function.
 */
gulp.task( 'build:color-scheme', [ 'build:color-scheme-meta' ], function() {
	var fileHeader            = '<?php\nfunction strathcom_get_color_scheme_css( $c ) {\n\tob_start(); ?>\n',
		fileFooter            = '\n<?php\n\treturn ob_get_flush();\n}\n',
		matchSCSSColorVar     = /^\s*\$([a-zA-Z0-9\-_]*):\s*/gm,
		matchQuasiCSSColorVar = /#var-([a-zA-Z0-9\-_]*)/g,
		stream, buildQuasiCSSVar, buildPHPVarEcho;

	/**
	 * Build quasi CSS variable like: `#var-{color-name}`.
	 *
	 * @param {string} match  The matched string.
	 * @param {string} name  Color slug.
	 * @returns {string}
	 */
	buildQuasiCSSVar = function( match, name ) {
		return '$' + name + ': #var-' + name + '; // ';
	};

	/**
	 * Build PHP escaped echo rule.
	 *
	 * @param {string} match  The matched string.
	 * @param {string} name  Color slug.
	 * @returns {string}
	 */
	buildPHPVarEcho = function( match, name ) {
		return '<?php esc_attr_e( $c[\'' + name + '\'] ); ?>';
	};

	stream = gulp
		.src( colorSchemePath, {
			base: globBase( paths.styles.input ).base
		} )
		.pipe( plumber() )
		.pipe( replace( matchSCSSColorVar, buildQuasiCSSVar, replaceOptions ) )
		.pipe( sass( config.sassArgs ).on( 'error', sass.logError ) )
		.pipe( rename( function( path ) {
			path.extname = '.php';
			path.basename = path.basename + '-css';
			if ( -1 !== path.dirname.indexOf( 'theme' ) ) {
				path.basename = path.basename + '-' + path.dirname;
			}
			return path;
		} ) )
		.pipe( flatten() )
		.pipe( postcss( [
			autoprefixer( config.autoprefixerArgs )
		] ) )
		.pipe( minify( config.minifyCSSArgs ) )
		.pipe( replace( matchQuasiCSSColorVar, buildPHPVarEcho, replaceOptions ) )
		.pipe( concat.header( fileHeader ) )
		.pipe( concat.footer( fileFooter ) )
		.pipe( gulp.dest( paths.styles.output ) );

	return stream;
} );
