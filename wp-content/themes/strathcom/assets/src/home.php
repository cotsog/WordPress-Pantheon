<?php
/**
 * The template for displaying the home page.
 *
 * @package    WordPress
 * @subpackage StrathcomCMS
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['splash_home'] = array(
	// @codingStandardsIgnoreStart
	// In case of static background image, use only 'background_image_src'
	//
	// 'background_image_src' => 'http://www.mayfieldtoyota.com/static/img/sienna-background.jpg',
	//
	// In case of fullscreen video, provide both 'background_image_src' as a poster and
	// 'fullscreen_video_src' for the video source.
	// @codingStandardsIgnoreEnd
	'background_image_src' => 'http://videvo.net/videvo_files/images/Stand_Park_Bridgemp4_upload_version.jpg',
	'fullscreen_video_src' => 'http://videvo.net/videvo_files/converted/2016_02/videos/Stand_Park_Bridgemp4_upload_version.mp483219.mp4',
	'title' => 'Step into your New Toyota',
	'subtitle' => 'At Mayfield Toyota Scion',
	'buttons' => array(
		0 => array(
			'url' => '#btn1',
			'text' => 'Shop New',
		),
		1 => array(
			'url' => '#btn2',
			'text' => 'Shop Used',
		),
	),
); // Passed to splash.twig.
$context['intro_front'] = array(
	'title' => 'Mayfield Toyota',
	'subtitle' => 'Driven to be Different',
	'description' => 'A Mayfield Toyota, we help you find the perfect vehicle. Of course, that\'s much more simple when you deal with one of the world\'s leading automakers, with a reputation of retained value, reliability, and strong safety ratings. So come for a visit. Let us show you how a dealership experience can be!',
	'description_style' => 'story',
	'desktop_buttons' => array(
		0 => array(
			'url' => '#blog',
			'text' => 'Read Our Blog',
		),
	),
	'mobile_buttons' => array(
		0 => array(
			'url' => '%phone_number%',
			'text' => 'CALL NOW!',
			'icon' => 'mobile',
		),
		1 => array(
			'url' => '#map-marker',
			'text' => 'Get Directions',
			'icon' => 'map-marker',
		),
		3 => array(
			'url' => '#new',
			'text' => 'Shop New',
		),
		4 => array(
			'url' => '#used',
			'text' => 'Shop Used',
		),
	),
); // Passed to intro.twig.
$context['slant_home_showroom'] = array(
	'content_position' => 'left',
	'background_image_src' => 'http://www.mayfieldtoyota.com/static/img/new-rav4-background.jpg',
	'content_image_src' => 'http://www.mayfieldtoyota.com/static/img/mayfield-toyota-corolla-edmonton-alberta.jpg',
	'title' => 'New Vehicle Showroom',
	'description' => 'The Corolla. The Camry. These two vehicles have set the industry standard for vehicle excellence for over two decades now, thanks to their stellar safety ratings, fuel economy, reliability, and retained value. And now they\'ve got company. With the edgy RAV4, the eco-friendly Prius, and the sprightly Yaris, your options for your favourite new toy grow more and more. Learn more about the newest lineup of sedans, hatchbacks, and SUVs available at Mayfield Toyota Scion.',
	'buttons' => array(
		0 => array(
			'url' => '#new-showroom',
			'text' => 'New Showroom',
		),
	),
); // Passed to slant.twig.
$context['slant_home_truck'] = array(
	'content_position' => 'right',
	'background_image_src' => 'http://www.mayfieldtoyota.com/static/img/tacoma-bg.jpg',
	'content_image_src' => 'http://www.mayfieldtoyota.com/static/img/mayfield-toyota-tacoma-edmonton-alberta.jpg',
	'title' => 'Mayfield Toyota Truck Centre',
	'description' => 'Why does it sometimes seem like Edmonton\'s roads contain nothing but trucks? We might be partly responsible for that. At Mayfield Toyota, we\'re a proud retailer of the Tacoma and Tundra, two of Canada\'s most reliable trucks. Our Parts &amp; Service Centre also provides the installations, upgrades, and regular maintenance you need to keep your workhorse on the road for years to come. Stop by our online showroom to learn more about our selection of pickups.',
	'buttons' => array(
		0 => array(
			'url' => '#trucks',
			'text' => 'Shop Trucks',
		),
		1 => array(
			'url' => '#suvs',
			'text' => 'Shop SUVs',
		),
	),
); // Passed to slant.twig.
$context['color_block_used'] = array(
	'title' => 'Used Vehicle Superstore',
	'subtitle' => '',
	'description' => "Some decisions are more important than others. Make sure that you're extra happy with your choice when you select a model from our Used Vehicle Inventory, because chances are that this vehicle will still be on the road and running 15 years from now! When you shop for a pre-owned car, truck, or SUV at Mayfield Toyota Scion, you know that only the best used vehicles have made our cut, and we stand behind their reliability. From Toyota, Scion, and many of the world's leading automakers, we're certain that you'll find a ride that's right for your and your family here at our Edmonton dealership.",
	'buttons' => array(
		0 => array(
			'url' => '#used',
			'text' => 'Shop Used',
		),
	),
	'content_image_src' => 'https://cms-sites-media.s3.amazonaws.com/cms-mayfield-toyota-development/media/cms_page_media/1/used-superstore-mayfield-toyota.png',
); // Passed to color-block.twig.
$context['color_block_service'] = array(
	'background_image_src' => 'http://www.mayfieldtoyota.com/static/img/country-side-parralax.jpg',
	'title' => 'Edmonton Toyota Service',
	'subtitle' => '',
	'description' => "It's true, Toyota vehicles stand above the fold when it comes to long-term reliability, making them some of the best vehicular investments you'll find. But to make them last even longer and keep their resale value famously high, you'll the help of the certified Toyota service experts here at Mayfield Toyota. Call our Service Centre or heck your owner's manual to see when you Toyota is due for its next visit.",
	'description_style' => 'story',
	'buttons' => array(
		0 => array(
			'url' => '#book',
			'text' => 'Book a Service Appointment',
		),
	),
	'content_figure_class' => 'img-overlay',
	'content_image_class' => 'toyota-oil-filter',
	'content_image_src' => 'http://www.mayfieldtoyota.com/static/img/brakes-toyota-mayfield.png',
); // Passed to color-block.twig.
$context['sbs_home'] = array(
	'title' => "Thanks for Visiting Edmonton's Choice Toyota Dealer!",
	'subtitle' => 'Mayfield Toyota Scion Used &amp; New Cars, Trucks, SUVs',
	'content_left' => "Mayfield Toyota Scion is proud to be your choice Edmonton Toyota dealer. We pride ourselves on providing superior quality products and automotive services to our customers in west end of Alberta's capital city. From our state-of-the-art Toyota Service Centre, to our collection of pre-owned cars and trucks, we are dedicated to creating long-lasting relationships with each of our customers, giving you no reason look elsewhere for all your sales and service needs. Welcome to Mayfield!

		As the leading Edmonton Toyota dealer, our expansive Toyota showroom houses an excellent selection of the latest models including the new Toyota RAV4, Corolla, Tundra, Tacoma, 4Runner, and Highlander, as well as the complete Scion lineup.",
	'content_right' => "If, instead, you are in the market for an affordable used Toyota model, known for their legendary reliability and retained value, then you've come to the right place! Not only do we offer a selection of Toyota Certified Used Vehicles—restored and warrantied for your piece of mind—but our Used Service Centre has the parts and master-level technician service you want to keep your motor running for years to come. Even if you don't drive a Toyota or Scion vehicle, our service bay doors are open to you!

	There is still plenty more to explore! Take a few minutes to browse through our website and see all of what Mayfield Toyota Scion has to offer you.",
); // Passed to side-by-side.twig.
Timber::render( array( 'home.twig', 'page.twig' ), $context );



