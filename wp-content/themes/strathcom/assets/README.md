HighStart
=========

Front-end Mobile-First Barebone start created using the gulp task manager.

### System requirements:

* **node** ver. >= 0.12 (recommended ver. 5+)
* **npm** ver. >= 3.3
* **bower**

Clone the repository, and, assuming your system matches the list of required software and versions above, from inside the theme's assets folder, run the following command to set things up:
**`npm install`**

During the installation process, if the following tools are not already available, they will be installed globally:

* **gulp** ver. >= 3.8.7

### Production

To generate production-ready, minified files run
**`gulp`**

This runs through the following actions:

* deleting the /dist folder contents
* compiling (html, styles, js, images)
* minifying (css, js), compressing images

### Development mode

To enable automatic compiling of the SASS files run:
**`gulp watch`**

This runs through the following actions:

* compiling (html, styles, js, images)
* listening for changes on all these resources
* issuing a [LiveReload](http://livereload.com/) server notice after a change is detected and the compilation finishes

**! Tip:** Use [LiveReload Extensions](http://is.gd/aAB8Sp) for the src updates to be visible in the browser automatically.

### Implementation description

For SASS compiling (tasks inside sass.js), libSass is used (no ruby dependency). PostCSS is used for both code linting the SASS code and autoprefixing. Sourcemaps are not used for CSS due to the splitting of mobile and tablet/desktop styles with some custom media-queries grouping script done in order to increase the site loading speed.

For Javascript (tasks inside scripts.js), JSHint is used for code linting. Browserify is used for dependency management.

For production-optimised images (tasks inside media.js) are optimised using imagemin, while pngquant is the tool used to optimise specifically the PNG files.

### Debugging tips

If you receive errors like
`EMFILE (too many open files)`
you will need to increase the open file descriptor limit.

The open file descriptor limit must be higher than 256 (this is the OSX default value).
Read your current number with the following command, and look for the open files value:
`ulimit -a`
You can change the value by appending
**`ulimit -n 4096`**
to your ~/.profile and ~/.bash_profile files.

due to the number of files that will be opened by npm install, the open file descriptor limit must be higher than 256 (osx default) - you can correct this using 'ulimit -a' to read your current number, and by adding something like 'ulimit -n 4096' to your ~/.profile file. This issue is identifiable by getting EMFILE (too many open files) errors while running npm install.

### Recommendation:

Make use of **[npm-check](http://is.gd/Y9B39x)** to keep your node and global modules up to date.

To install npm-check:
`npm install -g npm-check`

Start the interactive console for upgrading the global node modules with the following command:
`npm-check -g -u`
