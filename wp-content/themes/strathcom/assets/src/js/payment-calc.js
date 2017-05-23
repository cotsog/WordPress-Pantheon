var vehiclePrice,
	n,
	downPayment,
	loanAmount,
	salesTax,
	interestRate,
	rate,
	payments,
	term;

function calculatePayments() {
	vehiclePrice = jQuery( '#vehicle_price' ).val();
	vehiclePrice = vehiclePrice.replace( ',', '' );
	downPayment = jQuery( '#down_payment' ).val();
	downPayment = downPayment.replace( ',', '' );
	salesTax = ( jQuery( '#sales_tax' ).val() * 0.01 );
	loanAmount = ( vehiclePrice * ( 1 + salesTax ) ) - downPayment;
	interestRate = jQuery( '#interest_rate' ).val() / 100;
	term = jQuery( '#term' ).val();
	if ( 'bi-weekly' === jQuery( '#payment_frequency' ).val() ) {
		rate = interestRate / 52 * 2;
		n = term * ( 52 / 2 );
	} else {
		rate = interestRate / 12;
		n = term * 12;
	}
	payments = '$' + ( ( rate + ( rate / ( ( Math.pow( 1 + rate, n ) ) - 1 ) ) ) * loanAmount ).toFixed( 2 );
	return payments;
}

function initCalc() {
	jQuery( '.payments' ).html( calculatePayments() );
}

jQuery( '#calculate' ).on( 'click', function( event ) {
	jQuery( '.payments' ).html( calculatePayments() );
   event.preventDefault();
});

jQuery(function() {
	initCalc();
});
