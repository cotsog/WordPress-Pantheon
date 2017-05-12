/* globals jQuery, wp, _strathcomSlideExports */
/* exported strathcomSlideAdmin */
var strathcomSlideAdmin = ( function( $ ) {
	'use strict';

	var self = {
		frame: false
	};

	if ( 'undefined' !== typeof _strathcomSlideExports ) {
		$.extend( self, _strathcomSlideExports );
	}

	self.init = function() {
		$( '.upload-slide-img' ).on( 'click', function( e ) {
			e.preventDefault();
			self.uploadSlide();
		} );

		$( '.delete-slide-img' ).on( 'click', function( e ) {
			e.preventDefault();
			self.deleteSlide();
		} );

		$( 'input[name="slide_select"]' ).on( 'change', function() {
			self.switchSlideSelect( $( this ).val() );
		} );
	};

	self.uploadSlide = function() {
		if ( ! self.frame ) {
			self.frame = wp.media({
				frame: 'select',
				title: self.modalTitle,
				button: {
					text: self.buttonText
				},
				multiple: false
			});
		}

		self.frame.on( 'select', function() {
			var attachment = self.frame.state().get( 'selection' ).first().toJSON();
			self.checkDimensions( attachment );
			$( '.slide-image' ).empty().append( $( '<img>', { src: attachment.url } ) );
			$( '.slide_attachment_id' ).val( attachment.id );
			$( '.upload-slide-img' ).addClass( 'hidden' );
			$( '.delete-slide-img' ).removeClass( 'hidden' );
		});

		self.frame.open();
	};

	self.deleteSlide = function() {
		$( '.slide-image' ).empty();
		$( '.slide_attachment_id' ).val( '' );
		$( '.upload-slide-img' ).removeClass( 'hidden' );
		$( '.delete-slide-img' ).addClass( 'hidden' );
		$( '.slide-size-warning' ).addClass( 'hidden' );
	};

	self.checkDimensions = function( image ) {
		if ( image.width < self.slideMinWidth || image.height < self.slideMinHeight ) {
			$( '.slide-size-warning' ).removeClass( 'hidden' );
		} else {
			$( '.slide-size-warning' ).addClass( 'hidden' );
		}
	};

	self.switchSlideSelect = function( action ) {
		if ( 'manual' === action ) {
			$( '.slide_url_manual' ).show();
			$( '.slide_url_select' ).hide();
		} else {
			$( '.slide_url_select' ).show();
			$( '.slide_url_manual' ).hide();
		}
	};

	return self;
})( jQuery );
