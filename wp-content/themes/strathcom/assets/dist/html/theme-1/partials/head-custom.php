	<link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300|Roboto:400,300,100" rel="stylesheet" type="text/css">

	<?php if ( $is_fe_dev ) {
		// for local development, use the single file with sourceMaps
	?>
		<link type="text/css" rel="stylesheet" href="../../css/style-theme-1.css">
	<?php } else { ?>
		<link type="text/css" rel="stylesheet" href="../../css/style-theme-1-mobile.css">
		<link type="text/css" rel="stylesheet" href="#" data-min-width="544" data-href="../../css/style-theme-1-non-mobile.css">
	<?php } ?>

	<link type="text/css" rel="stylesheet" href="../../css/color-scheme-theme-1.css">
