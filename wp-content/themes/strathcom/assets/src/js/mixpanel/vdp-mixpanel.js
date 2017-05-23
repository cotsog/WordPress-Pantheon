jQuery( function( $ ) {
	'use strict';
	/*global mixpanel*/
	/*global performance*/
	/* global name */
	/* global year */
	/* global make */
	/* global model */
	/* global bodyType */
	/* global stockStatus */
	/* global stockNumber */
	/* global stockType */
	/* global vin */
	/* global trim */
	/* global trimDescription */
	/* global acode */
	/* global price */
	/* global specialPrice */
	/* global odometer */
	/* global dealerId */
	/* global itemKey */
	/* global color */
	/* global interiorColor */
	/* global engineLitres */
	/* global engineConfiguration */
	/* global engineCylinders */
	/* global transmission */
	/* global driveTrain */
	/* global fuelType */
	/* global doors */
	/* global isCertified */
	/* global isSpecialPrice */
	/* global seatingCapacity */
	/* global fuelConsumption */
	/* global daysInStock */
	/* global photoCount */

	// Variables
	var path            = window.location.pathname,
	    d               = new Date(),
	    page            = sessionStorage.getItem( 'page' ),
	    title           = sessionStorage.getItem( 'title' ),
	    referringName   = sessionStorage.getItem( 'referringName' ) ? sessionStorage.getItem( 'referringName' ) : 'N/A',
	    referringStock  = sessionStorage.getItem( 'referringStock' ) ? sessionStorage.getItem( 'referringStock' ) : 'N/A',
	    similarPosition = sessionStorage.getItem( 'similarPosition' ) ? sessionStorage.getItem( 'similarPosition' ) : 'N/A',
	    reloaded        = performance.navigation.type;

	// Create TIME!
	var date = ( d.getMonth() + 1 ) + '/' + d.getDate() + '/' + d.getFullYear();

	function addZero( i ) {
		if ( i < 10 ) {
			i = '0' + i;
		}
		return i;
	}

	function currentTime() {
		var hours   = d.getHours(),
		    minutes = addZero( d.getMinutes() ),
		    time    = hours + ':' + minutes;

		if ( hours >= 12 && hours <= 23 ) {
			time += ' PM';
		} else {
			time += ' AM';
		}
		return time;
	}

	// End TIME!

	// CAROUSEL!
	// Carousel Slider/Thumbnail Items Clicked
	/*$( '.slides' ).on( 'click', 'a', function() {
	 var type = $( this ).parent().parent().parent().parent().attr( 'class' ).split( ' ' )[ 0 ],
	 href = $( this ).attr( 'href' ),
	 position = $( this ).parent().index() + 1,
	 img = $( this ).children( 'img' ).attr( 'src' ),
	 alt = $( this ).children( 'img' ).attr( 'alt' );

	 if ( 'image-carousel' === type ) {
	 type = 'Thumbnail';
	 } else if ( 'image-slider' === type ) {
	 type = 'Slide';
	 }

	 mixpanel.track( 'Carousel ' + type + ' Clicked', {
	 'Vehicle': name,
	 'vin_number': vin,
	 'Stock #': stockNumber,
	 'Path': path,
	 'Image Path': img,
	 'Image Alt': alt,
	 'Position': position,
	 'href': href,
	 'Time': currentTime(),
	 'Date': date,
	 'Item': type
	 } );
	 } ); */

	// Previous/Next Carousel buttons clicked
	/*$( '.carousel-direction-nav' ).on( 'click', 'a', function() {
	 var type = $( this ).parent().parent().parent().attr( 'class' ).split( ' ' )[ 0 ],
	 direction = $( this ).text(),
	 current_position = $( '.carousel-active-slide' ).index() + 1,
	 previous_position;

	 if ( 'image-carousel' === type ) {
	 type = 'Thumbnail';
	 } else if ( 'image-slider' === type ) {
	 type = 'Slide';
	 }

	 if ( 'carousel-next' === $( this ).attr( 'class' ) ) {
	 previous_position = current_position - 1;
	 } else if ( 'carousel-prev' === $( this ).attr( 'class' ) ) {
	 previous_position = current_position + 1;
	 }

	 mixpanel.track( 'Previous/Next on ' + type + ' Clicked', {
	 'Vehicle': name,
	 'vin_number': vin,
	 'Stock #': stockNumber,
	 'Path': path,
	 'Direction': direction,
	 'Previous Slide Position': previous_position,
	 'Current Slide Position': current_position,
	 'Time': currentTime(),
	 'Date': date,
	 'Item': type + ' Arrows'
	 } );
	 } );*/

	// Detects if User clicks photo/video button below carousel
	/*$( '.image-count a' ).on( 'click', function() {
	 var href = $( this ).attr( 'href' ),
	 title = '';

	 if ( '#vehicle-images' === href ) {
	 title = 'Photo';
	 } else if ( '#vehicle-videos' === href ) {
	 title = 'Video';
	 } else {
	 title = 'Other';
	 }

	 mixpanel.track( title + ' Carousel Toggle Clicked', {
	 'Vehicle': name,
	 'vin_number': vin,
	 'Stock #': stockNumber,
	 'Path': path,
	 'Time': currentTime(),
	 'Date': date,
	 'Item': 'Carousel Toggle'
	 } );
	 } ); */

	// FORMS
	// Setup a handler to run when the form is submitted
	$( document ).bind( 'gform_confirmation_loaded', function( event, formId ) {
		mixpanel.track( 'Sent Lead', {
			'vehicle': name,
			'vin_number': vin,
			'stock_number': stockNumber,
			'dealer_id': dealerId,
			'path': path,
			'form_id': formId,
			'time': currentTime(),
			'date': date,
			'item': 'VDP Form',
			'year': year,
			'make_name': make,
			'model_name': model,
			'body_type': bodyType,
			'stock_status': stockStatus,
			'stock_type': stockType,
			'trim': trim,
			'trim_description': trimDescription,
			'acode_number': acode,
			'list_price': price,
			'special_price': specialPrice,
			'odometer': odometer,
			'item_key': itemKey,
			'exterior_colour': color,
			'interior_colour': interiorColor,
			'engine_litres': engineLitres,
			'engine_configuration': engineConfiguration,
			'engine_cylinders': engineCylinders,
			'transmission_desc': transmission,
			'transmission_type': driveTrain,
			'fuel_type': fuelType,
			'doors': doors,
			'is_certified': isCertified,
			'is_special_price': isSpecialPrice,
			'seating_capacity': seatingCapacity,
			'Fuel Economy - Highway': fuelConsumption.Highway,
			'Fuel Economy - City': fuelConsumption.City,
			'Fuel Economy - Combined': fuelConsumption.Combined,
			'Referring Vehicle': referringName,
			'Referring Vehicle Stock #': referringStock,
			'Vehicle Position in list': similarPosition,
			'days_in_stock': daysInStock,
			'photo_count': photoCount,
			'token': 'e198f7a3082558d9e685d33724574f30'
		} );
	} );

	// Dealer Info phone CTA
	/*$( '.vdp-dealer-info .phone-number' ).on( 'click', function() {
	 mixpanel.track( 'VDP Phone CTA clicked', {
	 'Vehicle': name,
	 'vin_number': vin,
	 'Stock #': stockNumber,
	 'Path': path,
	 'href': $( this ).attr( 'href' ),
	 'Text': $( this ).text(),
	 'Time': currentTime(),
	 'Date': date,
	 'Item': 'VDP Phone CTA'
	 } );
	 } );*/

	// VDP Sidebar CTA Block
	/*$( '.vdp-cta-block a, .incentives-learn-more' ).on( 'click', function() {
	 var position = $( this ).index() + 1,
	 href = $( this ).attr( 'href' ),
	 external = '';

	 // Check if the link is external
	 if ( location.hostname === this.hostname || !this.hostname.length ) {
	 external = 'No';
	 } else {
	 external = 'Yes';
	 }

	 mixpanel.track( 'VDP Sidebar - ' + $( this ).text() + ' Clicked', {
	 'Vehicle': name,
	 'vin_number': vin,
	 'Stock #': stockNumber,
	 'Path': path,
	 'href': href,
	 'Text': $( this ).text(),
	 'Position': position,
	 'External Link': external,
	 'Time': currentTime(),
	 'Date': date,
	 'Item': 'VDP Sidebar'
	 } );

	 $( '.vdp-accordion-section a[href="' + href + '"]' ).addClass( 'status' );
	 } );*/

	// Accordions
	/*$( '.vdp-accordion-section a' ).on( 'click', function() {
	 var status = '';

	 if ( $( this ).hasClass( 'collapsed' ) ) {
	 status = 'Opened';
	 } else {
	 status = 'Closed';
	 }

	 mixpanel.track( 'Accordion Clicked - ' + $( this ).text() + ' (' + status + ')', {
	 'Vehicle': name,
	 'vin_number': vin,
	 'Stock #': stockNumber,
	 'Path': path,
	 'href': $( this ).attr( 'href' ),
	 'Text': $( this ).text(),
	 'Status': status,
	 'Time': currentTime(),
	 'Date': date,
	 'Item': 'Accordion Clicked',
	 'Item Title': $( this ).text()
	 } );
	 } );*/

	// Similar Vehicles Section
	$( '.similar-vehicles a' ).on( 'click', function() {
		sessionStorage.setItem( 'page', 'vdp' );
		sessionStorage.setItem( 'title', 'Similar Vehicles' );
		sessionStorage.setItem( 'referringName', name );
		sessionStorage.setItem( 'referringStock', stockNumber );
		sessionStorage.setItem( 'similarPosition', $( this ).parent().index() + 1 );
	} );

	// VDP View
	function sendVDP( page, title ) {
		if ( 0 === reloaded ) {
			mixpanel.track( 'Viewed Vehicle', {
				'vehicle': name,
				'year': year,
				'make_name': make,
				'model_name': model,
				'body_type': bodyType,
				'stock_status': stockStatus,
				'stock_number': stockNumber,
				'stock_type': stockType,
				'vin_number': vin,
				'trim': trim,
				'trim_description': trimDescription,
				'acode_number': acode,
				'list_price': price,
				'special_price': specialPrice,
				'odometer': odometer,
				'dealer_id': dealerId,
				'path': path,
				'item_key': itemKey,
				'exterior_colour': color,
				'interior_colour': interiorColor,
				'engine_litres': engineLitres,
				'engine_configuration': engineConfiguration,
				'engine_cylinders': engineCylinders,
				'transmission_desc': transmission,
				'transmission_type': driveTrain,
				'fuel_type': fuelType,
				'doors': doors,
				'is_certified': isCertified,
				'is_special_price': isSpecialPrice,
				'seating_capacity': seatingCapacity,
				'Fuel Economy - Highway': fuelConsumption.Highway,
				'Fuel Economy - City': fuelConsumption.City,
				'Fuel Economy - Combined': fuelConsumption.Combined,
				'Referring Vehicle': referringName,
				'Referring Vehicle Stock #': referringStock,
				'Vehicle Position in list': similarPosition,
				'days_in_stock': daysInStock,
				'photo_count': photoCount,
				'Time': currentTime(),
				'Date': date,
				'Item': 'VDP View',
				'page_type': title,
				'token': 'e198f7a3082558d9e685d33724574f30'
			}, function() {
				sessionStorage.setItem( 'referringName', '' );
				sessionStorage.setItem( 'referringStock', '' );
				sessionStorage.setItem( 'page', '' );
				sessionStorage.setItem( 'title', '' );
				sessionStorage.setItem( 'similarPosition', '' );
			} );
		}
	}

	sendVDP( page, title );
} );
