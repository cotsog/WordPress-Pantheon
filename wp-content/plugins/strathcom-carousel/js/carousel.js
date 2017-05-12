/*exported strathcomCarousel, wp */
var strathcomCarousel = ( function( $ ) {

	var carousel = {

		/**
		 * DefaultContext
		 * @type {object}
		 */
		defaultContext: $( 'body' ),

		/**
		 * Interval
		 * @type {object}
		 */
		interval: null,

		/**
		 * Number of tries
		 * @type {Number}
		 */
		tries: 240,

		/**
		 * Initialise front-end carousel.
		 *
		 * @return void
		 */
		init: function() {
			if ( carousel.defaultContext.hasClass( 'wp-admin' ) ) {
				wp.shortcake.hooks.addAction( 'strathcom_carousel.id', carousel.shortcodeHook );
				carousel.interval = setInterval( carousel.tryInit, 2500 );
			} else {
				carousel.create();
			}
		},

		/**
		 * Try initialising when in admin.
		 *
		 * @return void
		 */
		tryInit: function() {
			if ( 'undefined' !== typeof wp.shortcake && 0 !== $( '#content_ifr' ).length ) {
				carousel.shortcodeHook();
			}
			if ( carousel.defaultContext.hasClass( 'wp-admin' ) ) {
				carousel.tries--;
				if ( 0 === carousel.tries ) {
					clearInterval( carousel.interval );
				}
			}
		},

		/**
		 * Create carousel in the admin (as a shortcode).
		 *
		 * @return void
		 */
		shortcodeHook: function() {
			carousel.create( $( '#content_ifr' ).contents() );
		},

		/**
		 * Create carousel for each container.
		 *
		 * @param  {object} context
		 * @return void
		 */
		create: function( context ) {
			if ( 'undefined' === typeof context ) {
				context = carousel.defaultContext;
			}
			context.find( '[data-toggle="carousel"]' ).each( carousel.update );
		},

		/**
		 * Update carousel.
		 *
		 * @return void
		 */
		update: function() {
			var el = $( this ),
				speed = Number( el.data( 'timing' ) ) || 5;

			el.flexslider( {
				namespace: 'carousel-',
				selector: '.slides > li',
				animation: 'slide',
				slideshowSpeed: speed,
				animationLoop: true,
				slideshow: true,
				touch: true
			} );
		}
	};

	/**
	 * Return public API.
	 */
	return {
		init: carousel.init
	};
})( jQuery );
