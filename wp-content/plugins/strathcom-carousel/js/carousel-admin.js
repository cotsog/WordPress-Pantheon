/* globals jQuery */
/* exported strathcomCarouselAdmin */
var strathcomCarouselAdmin = ( function( $ ) {
	'use strict';

	var displayMode = $( 'input[name="display-mode"]' ),
		toggleCarouselTiming;

	toggleCarouselTiming = function( value ) {
		$( '.carousel-timing' ).toggle( 'slider' === value );
	};

	toggleCarouselTiming( displayMode.filter( ':checked' ).val() );

	displayMode.on( 'change', function() {
		toggleCarouselTiming( this.value );
	} );

})( jQuery );
