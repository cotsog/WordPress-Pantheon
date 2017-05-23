/*global module*/
module.exports = ( function( $, global, _ ) {

	var activeClass = 'active',
		containerSelector = '[ data-toggle="tabs" ]',
		navSelector = '.tabs-nav a',
		contentSelector = '.tabs-content',
		paneSelector = '.tab-pane';

	/**
	 * Initialise tabs.
	 */
	function initialise( container ) {
		var activeTab, tabs = {};

		tabs.container = container;
		tabs.nav = container.find( navSelector ),
		tabs.content = container.find( contentSelector );
		tabs.panes = tabs.content.find( paneSelector );

		try {
			if ( _.isUndefined( tabs.nav ) || 0 === tabs.nav.length ) {
				throw new Error( 'Tabs: Could not initialise; there is no tabs navigation.' );
			}
			if ( _.isUndefined( tabs.panes ) || 0 === tabs.panes.length ) {
				throw new Error( 'Tabs: Could not initialise; there are no panes.' );
			}
		} catch ( e ) {
			window.console.error( e );
			return;
		}

		if ( '' !== document.location.hash ) {
			activeTab = tabs.nav.filter( '[href="' + document.location.hash + '"]' );
		}

		if ( 'undefined' === typeof activeTab || 0 === activeTab.length ) {
			activeTab = tabs.nav.filter( '.' + activeClass );
		}

		if ( 0 === activeTab.length ) {
			activeTab = tabs.nav;
		}
		activeTab = activeTab.first();
		toggle( activeTab, tabs );

		container.on( 'click', navSelector, function( e ) {
			e.preventDefault();
			window.location.hash = e.target.hash;
			toggle( $( e.target ), tabs );
		} );
	}

	/**
	 * Toggle tab.
	 */
	function toggle( tab, tabs ) {
		var pane = tabs.panes.filter( tab.attr( 'href' ) );

		tabs.nav.removeClass( activeClass );
		tab.addClass( activeClass );
		tab.trigger( 'tab:focus' );

		tabs.panes.removeClass( activeClass );
		pane.addClass( activeClass );
		pane.trigger( 'pane:focus' );
	}

	$.each( $( containerSelector ), function() {
		initialise( $( this ) );
	} );

	/**
	 * Return public API (empty).
	 */
	return {};

} )( jQuery, window, window._ );
