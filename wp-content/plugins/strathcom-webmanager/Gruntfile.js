module.exports = function( grunt ) {
  grunt.initConfig({

    // Get the configuration info from package.json
    pkg: grunt.file.readJSON( 'package.json' ),

    jshint: {
      options: {
        reporter: require( 'jshint-stylish' )
      },
      all: ['Grunfile.js']
    },

    scripts: {
      files: ['<%= jshint.all %>'],
      tasks: ['jshint']
    }
  });

  // Load plugins
  grunt.loadNpmTasks( 'grunt-contrib-jshint' );

  // Register tasks
  grunt.registerTask( 'default', ['jshint'] );
};
