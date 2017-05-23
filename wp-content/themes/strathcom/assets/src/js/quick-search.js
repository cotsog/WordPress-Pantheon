(function( $ ) {
	'use strict';

	var initialJSON = $.getJSON( '/wp-json/strathcom/vehicles/search/quick', function() {
		var Quicksearch  = {};
		var parseJSON    = $.parseJSON( initialJSON.responseText );
		var initialState = parseJSON.data.filters;

		if ( ! initialState.stock_type.hasOwnProperty( 'new' ) ) {
			$( '#quicksearchForm' ).addClass( 'no-type' );
		}

		Quicksearch = {
			init: function() {
				this.bindEvents();
				this.updateFilters( 'default' );
			},
			bindEvents: function() {

				//  Cleanup the form inputs so we don't send empty values
				$( '#quicksearchForm' ).on( 'submit', function( e ) {
					var params = '?' + $( '#quicksearchForm' ).serialize().replace( /[^&]+=&/g, '' ).replace( /&[^&]+=$/g, '' );
					e.preventDefault();

					//              MixPanel tracking here
					//              Submit the form once everythign has been cleanedup and event tracking has been completed.
					window.location.href = $( '#quicksearchForm' ).attr( 'action' ) + params;
				} );

				//          If this changes then you need to reset years, makes, and models
				$( '[name="stock_type"]' ).change( function() {
					Quicksearch.clearFilters( [ 'year', 'make', 'model' ] );
					Quicksearch.updateFilters( 'year' );
				} );

				//          If this changes again, you will need to clear out the makes and models
				$( '[name="year"]' ).change( function() {
					Quicksearch.clearFilters( [ 'make', 'model' ] );
					Quicksearch.updateFilters( 'make' );
				} );

				$( '[name="make"]' ).change( function() {
					Quicksearch.clearFilters( [ 'model' ] );
					Quicksearch.updateFilters( 'model' );
				} );
			},
			clearFilters: function( filters ) {
				var key;
				for ( key in filters ) {
					$( 'select[name=' + filters[ key ] + ']' ).find( 'option:gt(0)' ).remove();
				}
			},
			updateFilters: function( action ) {
				var selectedStockType = $( '#quicksearchForm select[name="stock_type"]' ).val();
				var selectedYear      = $( '#quicksearchForm select[name="year"]' ).val();
				var selectedMake      = $( '#quicksearchForm select[name="make"]' ).val();

				switch ( action ) {
					case 'year':

						//                  'new' would be the value from stock_type
						Quicksearch.PopulateField( initialState.stock_type[ selectedStockType ].years, 'year' );
						break;
					case 'make':

						//                  '2016' would be the value from years
						Quicksearch.PopulateField( initialState.stock_type[ selectedStockType ].years[ selectedYear ].makes, 'make' );
						break;
					case 'model':

						//                    'Mercedes-Benz' would be the value from makes
						//                    By this time, we can submit the form values and we will do any cleanup on the submit event.
						Quicksearch.PopulateField( initialState.stock_type[ selectedStockType ].years[ selectedYear ].makes[ selectedMake ].models, 'model' );
						break;
					default:
						Quicksearch.PopulateField( initialState.stock_type, 'stock_type' );

						//                  Pre-Select the first option ( New )
						$( '#quicksearchForm select[name="stock_type"] :nth-child(2)' ).attr( 'selected', 'selected' );

						//                  Update the year filters
						Quicksearch.updateFilters( 'year' );
				}
			},
			PopulateField: function( data, selector ) {
				var key;

				//          Something should sort the data here.
				for ( key in data ) {
					if ( data.hasOwnProperty( key ) ) {
						$( 'select[name="' + selector + '"]' ).append( '<option value="' + key.replace( '&', '&amp;' ) + '">' + Quicksearch.TitleCase( key ) + '</option>' );
					}
				}
			},
			TitleCase: function( str ) {
				return str.replace( /\w\S*/g, function( txt ) {
					return txt.charAt( 0 ).toUpperCase() + txt.substr( 1 ).toLowerCase();
				} );
			}
		};

		Quicksearch.init();
	} );
})( jQuery );
