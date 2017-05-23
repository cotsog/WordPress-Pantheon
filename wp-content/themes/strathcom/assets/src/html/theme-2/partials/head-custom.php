	<script src="https://use.typekit.net/lik5flc.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>

	<?php if ( $is_fe_dev ) {
		// for local development, use the single file with sourceMaps
	?>
		<link type="text/css" rel="stylesheet" href="../../css/style-theme-2.css">
	<?php } else { ?>
		<link type="text/css" rel="stylesheet" href="../../css/style-theme-2-mobile.css">
		<link type="text/css" rel="stylesheet" href="#" data-min-width="544" data-href="../../css/style-theme-2-non-mobile.css">
	<?php } ?>


