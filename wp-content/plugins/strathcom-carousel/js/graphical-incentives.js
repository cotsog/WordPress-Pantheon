/* globals jQuery, wp, _, _strathcomGraphicalIncentivesExports */
/* exported strathcomGraphicalIncentives */
var strathcomGraphicalIncentives = ( function( $ ) {
	'use strict';

	var self = {
		info: [],
		frame: false
	};

	// Exports must be used to fill the previewData.
	if ( 'undefined' !== typeof _strathcomGraphicalIncentivesExports ) {
		$.extend( self.info, _strathcomGraphicalIncentivesExports );
	}

	self.init = function() {
		self.info.saveButton = '#incentives-button';
		self.info.slideTitle = '#title';
		self.info.previewImg = '#incentives-preview-image';
		self.info.uploadImg = '.upload-incentive-img';
		self.info.deleteImg = '.delete-incentive-img';
		self.info.imgID = '#slide-attachment-id';
		self.info.startDate = '#start-date';
		self.info.startHours = '#start-time-hours';
		self.info.startMins = '#start-time-minutes';
		self.info.endDate = '#end-date';
		self.info.endHours = '#end-time-hours';
		self.info.endMins = '#end-time-minutes';
		self.info.errorMsg = '#notice-error';
		self.info.sizeMsg = '.slide-size-warning';
		self.info.slideUrl = '#slide-url';
		self.info.slideTarget = '#slide-target';
		self.info.filter = '#filter-sites';
		self.info.siteSelect = '.site-select';
		self.info.filterOem = '#filter-oem';
		self.info.filterProvince = '#filter-province';
		self.info.filterCountry = '#filter-country';

		self.info.trashLink = '.toplevel_page_strathcom_graphical_incentives .submitdelete';

		$( document ).ready( function() {
			self.watchFilters();
			self.watchResetButton();
			self.watchSaveButton();
			self.watchTrashLink();

			$( self.info.uploadImg ).on( 'click', function( e ) {
				e.preventDefault();
				self.uploadSlide();
			} );

			$( self.info.deleteImg ).on( 'click', function( e ) {
				e.preventDefault();
				self.deleteSlide();
			} );

			$( self.info.startDate + ', ' + self.info.endDate ).datepicker();

			$( self.info.filter ).on( 'click', function( e ) {
				e.preventDefault();
				self.filterSites();
			} );

			$( self.info.filterCountry ).on( 'change', function( e ) {
				e.preventDefault();
				self.toggleProvinces();
			} );
		});
	};

	/*
	 * Watch for click on the Save button.
	 */
	self.watchSaveButton = function() {
		$( self.info.saveButton ).click( function( e ) {
			e.preventDefault();
			self.saveForm();
		});
	};

	/*
	 * Watch for click on the Reset button.
	 */
	self.watchResetButton = function() {
		$( '#reset-button' ).click( function( e ) {
			e.preventDefault();
			$( 'select', '.filter' ).each( function() {
				$( this ).val( 'any' ).trigger( 'change' );
			});
		});
	};

	/*
	 * Watch filters for change.
	 */
	self.watchFilters = function() {
		var className = '';
		$( 'select', '#filters' ).each( function() {
			$( this ).change( function() {
				className = $( this ).val();
				$( '.site-title' ).each( function() {
					if ( $( this ).hasClass( className ) ) {
						$( this ).removeClass( 'hidden' );
					} else {
						$( this ).addClass( 'hidden' );
					}
				});
			});
		});
	};

	/*
	 * Watch the Trash Link.
	 */
	self.watchTrashLink = function() {
		var id, confirm;
		$( self.info.trashLink ).each( function() {
			$( this ).click( function( e ) {
				id = $( this ).data( 'id' );
				e.preventDefault();

				confirm = window.confirm( self.info.confirmDeleteText );
				if ( true === confirm ) {
					self.deleteIncentive( id );
				}
			});
		});
	};

	/*
	 * Upload an image.
	 */
	self.uploadSlide = function() {

		if ( self.frame ) {
			self.frame.open();
			return;
		}

		self.frame = wp.media({
			frame: 'select',
			title: self.info.modalTitle,
			button: {
				text: self.info.buttonText
			},
			library: {
				type: 'image'
			},
			multiple: false
		});

		self.frame.on( 'select', function() {
			var attachment = self.frame.state().get( 'selection' ).first().toJSON();
			$( self.info.previewImg ).empty().append( $( '<img>', { src: attachment.url } ) );
			$( self.info.imgID ).val( attachment.id );
			$( self.info.uploadImg ).addClass( 'hidden' );
			$( self.info.deleteImg ).removeClass( 'hidden' );
		});

		self.frame.open();
	};

	/*
	 * Remove the image.
	 */
	self.deleteSlide = function() {
		$( self.info.previewImg ).empty();
		$( self.info.imgID ).val( '0' );
		$( self.info.uploadImg ).removeClass( 'hidden' );
		$( self.info.deleteImg ).addClass( 'hidden' );
		$( self.info.sizeMsg ).addClass( 'hidden' );
	};

	/*
	 * Save the form.
	 */
	self.saveForm = function() {
		var request,
			carousels = self.getCheckedCarousels();

		if ( true !== self.validate() ) {
			$( self.info.errorMsg ).each( function() {
				$( this ).show();
				$( 'html, body' ).animate( {

					// 40 accounts for height of the admin bar.
					scrollTop: ( $( this ).offset().top - 40 )
				}, 300 );
			});
			return;
		} else {
			$( self.info.errorMsg ).hide();
		}

		$( self.info.saveButton ).attr( 'disabled', 'disabled' );

		request = wp.ajax.post( self.info.saveAction, {
			nonce: self.info.nonce,
			data: {
				post_id: $( '#post-id' ).val(),
				title: $( self.info.slideTitle ).val(),
				start_date: $( self.info.startDate ).val(),
				start_hours: $( self.info.startHours ).val(),
				start_mins: $( self.info.startMins ).val(),
				end_date: $( self.info.endDate ).val(),
				end_hours: $( self.info.endHours ).val(),
				end_mins: $( self.info.endMins ).val(),
				img_id: $( self.info.imgID ).val(),
				slide_url: $( self.info.slideUrl ).val(),
				slide_url_target: $( self.info.slideTarget ).val(),
				carousels: carousels
			}
		});

		request.done( function( postId ) {
			var uri = window.location.href,
				key = 'gi_id';

			if ( isNaN( parseFloat( postId ) || ! isFinite( postId ) ) ) {
				$( self.info.saveButton ).removeAttr( 'disabled' );
				return;
			}

			uri = self.updateQueryVar( uri, key, postId );
			uri = self.updateQueryVar( uri, 'updated', '1' );
			window.location.replace( uri );
		});
	};

	/*
	 * Delete an incentive.
	 */
	self.deleteIncentive = function( id ) {
		var request;

		if ( ! id ) {
			return;
		}
		request = wp.ajax.post( self.info.deleteAction, {
			nonce: self.info.nonce,
			data: {
				post_id: id
			}
		});

		request.done( function( postId ) {
			var uri = window.location.href,
				key = 'deleted_id';

			uri = self.updateQueryVar( uri, key, postId );
			window.location.replace( uri );
		});
	};

	/*
	 * Validate the form.
	 */
	self.validate = function() {
		var result = true,
			startTime = self.startTime(),
			endTime = self.endTime(),
			selfNow = new Date( self.info.now );

		$( self.info.slideTitle + ', ' + self.info.uploadImg + ', ' + self.info.startDate + ', ' + self.info.endDate )
			.removeClass( 'error' );

		if ( '' === $( self.info.slideTitle ).val() ) {
			$( self.info.slideTitle ).addClass( 'error' );
			result = false;
		}
		if ( '' === $( self.info.imgID ).val() || '0' === $( self.info.imgID ).val() ) {
			$( self.info.uploadImg ).addClass( 'error' );
			result = false;
		}

		/*
		 * Expanding the conditionals below for clarity.
		 */

		if ( ! startTime ) {
			startTime = '';
		}

		if ( ! endTime ) {
			endTime = '';
		}

		// If start date is after end date...
		if ( ( '' !== startTime && '' !== endTime ) && ( startTime >= endTime ) ) {
			$( self.info.startTime + ', ' + self.info.endDate ).addClass( 'error' );
			result = false;
		}

		if ( selfNow >= endTime && '' !== endTime ) {
			$( self.info.endDate ).addClass( 'error' );
			result = false;
		}

		return result;
	};

	/*
	 * Create an array of checkbox values.
	 */
	self.getCheckedCarousels = function() {
		var carousels = [];
		$( '.selected-carousel' ).each( function() {
			if ( true === $( this ).prop( 'checked' ) ) {
				carousels.push( $( this ).val() );
			}
		});
		return carousels;
	};

	/*
	 * Get the full Start Time
	 */
	self.startTime = function() {
		var startDate = $( self.info.startDate ).datepicker( 'getDate' ),
			startHours = $( self.info.startHours ).val(),
			startMins = $( self.info.startMins ).val();

		if ( ! startDate ) {
			return;
		}

		startDate = new Date( startDate.setHours( startHours ) );
		return new Date( startDate.setMinutes( startMins ) );
	};

	/*
	 * Get the full End Time
	 */
	self.endTime = function() {
		var endDate = $( self.info.endDate ).datepicker( 'getDate' ),
			endHours = $( self.info.endHours ).val(),
			endMins = $( self.info.endMins ).val();

		if ( ! endDate ) {
			return;
		}

		endDate = new Date( endDate.setHours( endHours ) );
		return new Date( endDate.setMinutes( endMins ) );
	};

	/*
	 * Place
	 */
	self.updateQueryVar = function( uri, key, value ) {
		var regex = new RegExp( '([?&])' + key + '=.*?(&|$)', 'i' ),
			separator = uri.indexOf( '?' ) !== -1 ? '&' : '?';

		if ( uri.match( regex ) ) {
			return uri.replace( regex, '$1' + key + '=' + value + '$2' );
		} else {
			return uri + separator + key + '=' + value;
		}
	};

	/**
	 * Filter Sites
	 */
	self.filterSites = function() {
		var filterOem = [ $( self.info.filterOem ).val(), 'oems' ],
			filterProvince = [ $( self.info.filterProvince ).val(), 'province' ],
			filterCountry = [ $( self.info.filterCountry ).val(), 'country' ];

		// Remove any filters which have been set to 'any'.
		var filterChecks = _.filter( [ filterOem, filterProvince, filterCountry ], function( filter ) {
			return 'any' !== filter[0];
		} );

		// If we have any filters left that were selected, apply them.
		if ( filterChecks.length > 0 ) {

			// Hide all site select boxes.
			$( self.info.siteSelect ).hide();

			// Run through each one and validate it matches the filters.
			$( self.info.siteSelect ).each( function() {
				var showSelect = true;
				var selector = $( this );

				_.each( filterChecks, function( filter ) {

					// Pass in the value of the select and the value of the data element on the div i.e. data-oems.
					if ( ! self.checkFilterMatch( filter[0], selector.data( filter[1] ) ) ) {
						showSelect = false;
					}
				});

				// All filters matched, show the select.
				if ( showSelect ) {
					selector.show();
				}
			} );
		} else {

			// Show all in case any have been hidden.
			$( self.info.siteSelect ).show();
		}

		if ( 0 === $( self.info.siteSelect ).filter( ':visible' ).length ) {
			$( '.sites-warning' ).show();
		} else {
			$( '.sites-warning' ).hide();
		}
	};

	/**
	 * Check that a filter matches a data attribute
	 *
	 * @param {string} filter The filter selected in the drop down.
	 * @param {string} values The value of the data-element on the div.
	 * @returns {boolean}
	 */
	self.checkFilterMatch = function( filter, values ) {
		var pass = false;

		// Some values are comma separated, so we should run through each one.
		_.each( values.split( ',' ), function( value ) {
			if ( filter.toLowerCase() === value.toLowerCase() ) {
				pass = true;
			}
		} );

		return pass;
	};

	/**
	 * Toggle the provinces filter depending on if Canada was selected or not.
	 */
	self.toggleProvinces = function() {
		if ( 'canada' === $( self.info.filterCountry ).val() ) {
			$( self.info.filterProvince ).show();
		} else {

			// Select the any value so that it doesn't apply when hidden.
			$( self.info.filterProvince ).val( 'any' );
			$( self.info.filterProvince ).hide();
		}
	};

	return self;

})( jQuery );
