/* global require */

var grunt = require( 'grunt' );

grunt.initConfig({
	uglify: {
		options: {
			preserveComments: false
		},
		core: {
			files: [ {
				expand: true,
				cwd: 'js/',
				src: [
					'carousel.js',
					'!*.min.js'
				],
				dest: 'js/',
				ext: '.min.js'
			} ]
		}
	}
});

grunt.loadNpmTasks( 'grunt-contrib-uglify' );
