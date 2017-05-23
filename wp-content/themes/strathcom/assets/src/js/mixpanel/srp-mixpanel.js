jQuery( function( $ ) {
	'use strict';
	/*global mixpanel*/

	//Variables
	var path = window.location.pathname;

	// Sets the page referring page
	sessionStorage.setItem( 'page', 'srp' );
	sessionStorage.setItem( 'title', 'Search Results Page' );

	// Handles vehicle click
	$( '.search-results li, .search-results li .product-cta > a' ).on( 'click', function() {
		sessionStorage.setItem( 'page', 'srp' );
		sessionStorage.setItem( 'title', 'Viewed Vehicle' );
	} );

	// Sidebar Inventory Filters
	$( '.filters-sidebar' ).on( 'click', 'a', function() {
		var position = $( this ).parent().index() + 1,
		    category = $( this ).parent().parent().parent().prev( 'dt' ).text();

		mixpanel.track( 'SRP Filters - ' + $( this ).text() + ' Clicked', {
			'Path': path,
			'Category': category,
			'Text': $( this ).text(),
			'Position': position,
			'Item': 'SRP Filter'
		} );
	} );
} );
