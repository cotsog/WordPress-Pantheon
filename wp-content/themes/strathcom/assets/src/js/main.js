/*jshint browserify: true, unused: false*/
/* globals noUiSlider */

(function( $, global, _ ) {

	'use strict';

	var App,
		DropdownNested = require( './dropdown-nested' ),
		Tabs = require( './tabs' );

	global.Util = require( '../../bower_components/bootstrap/dist/js/umd/util.js' );
	global.Collapse = require( '../../bower_components/bootstrap/dist/js/umd/collapse.js' );

	global.strat = global.strat || {

		/**
		 * Init Function
		 */
		init: function() {
			App.jsStart();
			App.initCollapsibleHeader();
			App.initRevealEffect();
			App.initImageSlider();
			App.initLightbox();
			App.initAccordions();
			App.initTogglers();
			App.initSplash();
			App.printStart();
			App.initDismissable();
			App.initRange();
			if ( 'undefined' !== typeof global.strathcomSearch ) {
				global.strathcomSearch.on( 'filters:render:after', App.initRange );
			}
		},

		/**
		 * Remove nojs fallbacks
		 */
		jsStart: function() {
			$( 'html' ).removeClass( 'nojs' );
		},

		/**
		 * Print
		 */
		printStart: function() {
			$( '._print' ).click( function( e ) {
				e.preventDefault();
				window.print();
			} );
		},

		/**
		 * Initialize range slider
		 */
		initRange: function() {
			var rangeSliderMin, rangeSliderMax, minValue, maxValue,
				rangeSlider = document.getElementById( 'range-slider' );

			if ( 'undefined' === typeof noUiSlider || ! rangeSlider  ) {
				return;
			}

			rangeSliderMin = $( '#price_range__gte' );
			rangeSliderMax = $( '#price_range__lte' );
			minValue = parseInt( rangeSliderMin.val(), 10 );
			maxValue = parseInt( rangeSliderMax.val(), 10 );

			noUiSlider.create( rangeSlider, {
				start:   [ minValue, maxValue ],
				connect: true,
				range:   {
					'min': minValue,
					'max': maxValue
				}
			} );

			rangeSlider.noUiSlider.on( 'update', function( values, handle ) {
				var value = values[ handle ];
				value     = Math.round( value / 1000 ) * 1000;
				if ( handle ) {
					if ( value < 1000 ) {
						value = 1000;
					}
					rangeSliderMax.val( value );
				} else {
					rangeSliderMin.val( value );
				}
			} );

			rangeSliderMin.on( 'change', function() {
				rangeSlider.noUiSlider.set( [ this.value, null ] );
			} );

			rangeSliderMax.on( 'change', function() {
				rangeSlider.noUiSlider.set( [ null, this.value ] );
			} );
		},

		/**
		 * Site header expand/collapse.
		 */
		initCollapsibleHeader: function() {
			var offset, scrollVal, container, isExpanded,
				expandedClass = 'expanded-header',
				addBackground = 'add-background',
				wnd = $( window );

			// Trigger feature only on homepage.
			if ( ! $( 'body' ).hasClass( 'home' ) || 0 === $( '.collapsible-header' ).length ) {
				return;
			}

			offset = ( $( '.splash' ).height() * 0.66 ) || 650;
			container = $( '.page-wrapper' );
			isExpanded = container.hasClass( expandedClass );

			// Throttle event handler function for better performance.
			wnd.on( 'scroll', _.throttle( function( event ) {
				scrollVal = wnd.scrollTop();

				if ( isExpanded && scrollVal > offset ) {
					isExpanded = false;
					container.removeClass( expandedClass );
					container.addClass( addBackground );
				} else if ( ! isExpanded && scrollVal < offset ) {
					isExpanded = true;
					container.addClass( expandedClass );
					container.removeClass( addBackground );
				}
			}, 100 ) );

			wnd.trigger( 'scroll' );
		},

		/**
		 * Reveal effect using 'jquery.visible'.
		 */
		initRevealEffect: function() {
			var scrollVal, show,
				wnd = $( window ),
				targets = [
					{
						container: $( '.container-slant' ),
						el: [
							{
								selector: '.content, figure',
								effect: 'fade-slide'
							}
						]
					}
				];

			show = function( target ) {
				_.each( target.el, function( el ) {
					target.container.find( el.selector ).addClass( el.effect );
				});
				target.shown = true;
			};

			if ( 'undefined' === typeof jQuery.fn.visible ) {
				_.each( targets, function( target ) {
					show( target );
				});
				return false;
			}

			// Throttle event handler function for better performance.
			wnd.on( 'scroll', _.throttle( function() {
				scrollVal = wnd.scrollTop();

				_.each( targets, function( target ) {
					if ( ! _.isUndefined( target.shown ) && true === target.shown ) {
						return;
					}
					if ( target.container.visible( true ) ) {
						show( target );
					}
				});
			}, 100 ) );

			wnd.trigger( 'scroll' );
		},

		/**
		 * Initialise image sliders and carousels
		 */
		initImageSlider: function() {
			$.each( $( '[data-toggle="product-carousel"]' ), function() {
				var commonConfig, carouselConfig, sliderConfig, size, getGridSize, setGridSize, refreshFlexslider,
					container   = $( this ),
					slider      = container.find( '.image-slider' ),
					carousel    = container.find( '.image-carousel' ),
					hasSlider   = ( 0 !== slider.length ),
					hasCarousel = ( 0 !== carousel.length );

				// Define common config.
				commonConfig = {
					namespace:     'carousel-',
					selector:      '.slides > li',
					animation:     'slide',
					controlNav:    false,
					animationLoop: false,
					slideshow:     false,
					touch:         true
				};

				// Extend common config with specific settings for each slider type.
				if ( hasCarousel ) {
					getGridSize = function() {
						var gridSize = Number( carousel.data( 'grid-size' ) );

						if ( 600 > carousel.width() ) {
							return Math.ceil( gridSize / 4 );
						} else if ( 900 > carousel.width() ) {
							return Math.ceil( gridSize / 2 );
						} else {
							return gridSize;
						}
					};

					setGridSize = function() {
						var gridSize = getGridSize();

						carousel.data( 'flexslider' ).vars.minItems = gridSize;
						carousel.data( 'flexslider' ).vars.maxItems = gridSize;
						carousel.flexslider( 0 );
					};

					size = getGridSize();
					carouselConfig = $.extend( {}, commonConfig, {
						itemWidth:  120,
						itemMargin: 0,
						minItems:   size,
						maxItems:   size
					} );
				}

				if ( hasSlider ) {
					sliderConfig = $.extend( {}, commonConfig, {} );
				}

				// Sync carousel and slider if they are both present.
				if ( hasCarousel && hasSlider ) {
					carouselConfig.asNavFor = slider;
					sliderConfig.sync = carousel;
				}

				refreshFlexslider = function( e ) {
					var instance = e.data.instance.data( 'flexslider' ),
						currentItem = instance.currentItem;

					instance.setup();
					instance.flexslider( currentItem );
				};

				// Initialise flexslider.
				if ( hasSlider ) {
					slider.flexslider( sliderConfig );
					slider.closest( '.tab-pane' ).one( 'pane:focus', { instance: slider }, refreshFlexslider );
				}

				if ( hasCarousel ) {
					carousel.flexslider( carouselConfig );
					carousel.closest( '.tab-pane' ).one( 'pane:focus', { instance: carousel }, refreshFlexslider );
					$( window ).on( 'resize', _.throttle( setGridSize, 100 ) );
				}
			});
		},

		/**
		 * Initialise lightbox
		 */
		initLightbox: function() {
			global.baguetteBox.run( '[data-lightbox]' );
		},

		/**
		 * Initialise accordions
		 */
		initAccordions: function() {
			var accordionTriggers = '.filters dt';
			var accordionWrapper = $( '.filters-panel' );
			accordionWrapper.on( 'click', accordionTriggers, function( e ) {
				e.preventDefault();
				$( this ).toggleClass( 'state-closed' );
			} );
		},

		/**
		 * Initialise togglers
		 */
		initTogglers: function() {
			var togglerTriggers = $( '[data-toggled]' );
			togglerTriggers.on( ' click', function( e ) {
				e.preventDefault();
				$( $( this ).data( 'toggled' ) ).toggleClass( 'state-toggled' );
			} );
		},

		/**
		 * Set splash height and control video playback and visibility on scroll.
		 */
		initSplash: function() {
			var offset, top, toggleVideo, setOffset, controlVideo,
				video = null,
				isPaused = false,
				splash = $( '.splash' ),
				isVideoSplash = false,
				wrapper = $( '.page-wrapper' ),
				header = $( '.site-header' ),
				wnd = $( window );

			// Trigger feature only for splash with video background.
			if ( 0 === splash.length ) {
				return;
			}

			isVideoSplash = splash.hasClass( 'splash-video' ) && 0 !== splash.find( 'iframe' ).length;

			// Control YouTube video using its API methods.
			controlVideo = function( cmd, args ) {
				if ( _.isUndefined( global.strathcomVideoSplashPlayer ) ) {
					return;
				}
				if ( _.isNull( video ) ) {
					video = global.strathcomVideoSplashPlayer;
				}
				if ( 'play' === cmd ) {
					video.playVideo();
				} else if ( 'pause' === cmd ) {
					video.pauseVideo();
				} else if ( 'setSize' === cmd ) {
					video.setSize( 16 / 9 * args.height, args.height );
				}
			};

			// Control video playback and visibility on page scroll.
			toggleVideo = function() {
				var scrollVal = wnd.scrollTop(),
					inViewport = ( scrollVal >= top && scrollVal <= top + offset ) || ( scrollVal <= top && scrollVal + offset >= top );

				if ( ! isPaused && ! inViewport ) {
					isPaused = true;
					controlVideo( 'pause' );
					splash.css( 'visibility', 'hidden' );
				} else if ( isPaused && inViewport ) {
					isPaused = false;
					controlVideo( 'play' );
					splash.css( 'visibility', '' );
				}
			};

			// Determine and set splash height (offset for scroll) on resize.
			setOffset = function() {
				offset = wnd.height();
				top = splash.offset().top;
				if ( ! wrapper.hasClass( 'expanded-header' ) ) {
					offset = offset - header.outerHeight();
				}

				//Splash.height( offset );
				if ( isVideoSplash ) {
					controlVideo( 'setSize', { height: offset } );
					toggleVideo();
				}
			};
			setOffset();

			// Throttle expensive functions for better performance.
			wnd.on( 'resize', _.throttle( setOffset, 100 ) );
			if ( isVideoSplash ) {
				wnd.on( 'scroll', _.throttle( toggleVideo, 100 ) );
			}
		},

		/**
		 * Initialise dismiss-able notifications.
		 */
		initDismissable: function() {
			_.each( $( '[data-trigger="dismiss"]' ), function( notification ) {
				var hideNotification,
					$el          = $( notification ),
					toggle       = $el.find( '[data-toggle="dismiss"]' ),
					dismissAfter = $el.data( 'dismiss-after' );

				/**
				 * Hide notification.
				 * @param {Event} e
				 */
				hideNotification = function( e ) {
					if ( ! _.isUndefined( e ) ) {
						e.preventDefault();
					}
					$el.fadeOut( 360 );
				};

				/**
				 * Listen for click event only once.
				 */
				toggle.one( 'click', hideNotification );

				/**
				 * If notification is to be dismissed automatically, add delay.
				 */
				if ( ! _.isUndefined( dismissAfter ) && 0 < dismissAfter ) {
					_.delay( hideNotification, dismissAfter );
				}
			}, this );
		}
	};

	App = global.strat;

	$(function() {
		App.init();
	});

})( jQuery, window, window._ );
