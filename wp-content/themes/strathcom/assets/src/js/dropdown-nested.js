/*global module*/
module.exports = ( function( $ ) {

	var init,
		toggle,
		clearMenus,
		menus = [],
		dropdown = '.dropdown-menu',
		triggerSelector = '[data-toggle="dropdown-nested"]';

	/**
	 * Init Function
	 */
	init = function() {
		var dropdownTrigger = $( '<button>', {
			'class': 'dropdown-trigger',
			'data-toggle': 'dropdown-nested'
		} );

		$.each( $( triggerSelector ), function() {
			menus.push( $( $( this ).data( 'target' ) ) );
		} );

		$.each( $( dropdown ), function() {
			$( this ).before( dropdownTrigger.clone() );
			menus.push( $( this ) );
		} );

		$( document )
			.on( 'click', triggerSelector, toggle )
			.on( 'click', clearMenus );
	};

	/**
	 * Toggle dropdown
	 */
	toggle = function( event ) {
		var trigger = $( event.currentTarget );
		var menu = trigger.siblings( 'ul' );
		if ( trigger.data( 'target' ) ) {
			menu = $( trigger.data( 'target' ) );
		}
		if ( menu.hasClass( 'open' ) ) {
			trigger.removeClass( 'active' );
			menu.removeClass( 'open' );
		} else {

			// Close the other 2nd level menus if we are opening a new 2nd level menu
			if ( menu.hasClass( 'dropdown-menu' ) ) {
				$( '> .dropdown-menu' ).removeClass( 'open' ).siblings( '.dropdown-trigger' ).removeClass( 'active' );
			}
			trigger.addClass( 'active' );
			menu.addClass( 'open' );
		}
	};

	/**
	 * Clear dropdowns
	 */
	clearMenus = function( event ) {
		var target = $( event.target );

		if ( target.is( triggerSelector ) ) {
			event.preventDefault();
			event.stopPropagation();
			return;
		}

		$( triggerSelector ).removeClass( 'active' );
		$.each( menus, function() {
			$( this ).removeClass( 'open' );
		} );
	};

	/**
	 * Initialise
	 */
	init();

	/**
	 * Return public API ( empty )
	 */
	return {};

} )( jQuery );
