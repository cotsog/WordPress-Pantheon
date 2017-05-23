<?php include '../partials-common/contact-form.php'; ?>
<?php include '../partials-common/head-start.php'; ?>
<?php include 'partials/head-custom.php'; ?>
<?php include '../partials-common/head-end.php'; ?>
<body>
<?php include '../partials-common/header.php'; ?>

	<div class="site-content layout-vdp">
		<div class="group">
			<div class="group-content">

				<!-- Maybe use more specific http://schema.org/Vehicle? To do: ask client about it -->
				<main itemscope="" itemtype="http://schema.org/Product" class="product-brochure" role="main">

					<div class="product-brochure-utils">
						<ol class="breadcrumb">
							<li><a href="#">NEW</a></li>
							<li><a href="#">Toyota</a></li>
							<li><a href="#">4Runner</a></li>
							<li><a href="#">2016</a></li>
						</ol>
						<ul class="tools">
							<li class="tools-share"><a href="#">Share</a></li>
							<li class="tools-print"><a class="_print" href="#">Print</a></li>
						</ul>
					</div>

					<header class="product-brochure-header">
						<h1>2016 Toyota 4Runner for sale in Edmonton, Alberta</h1>
						<a href="tel:+17805329333" class="call-us">Questions? Call us! <strong>(780) 532-9333</strong></a>
					</header>

					<figure class="product-gallery" data-toggle="product-carousel">
						<div class="image-slider carousel">
							<ul class="slides" data-lightbox>
								<li>
									<a href="http://photos.strathcom.com/image/show/960x_/564657759f40e368bb0c134d.jpg">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/526x394/564657759f40e368bb0c134d.jpg" width="526" height="394" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
								<li>
									<a href="http://photos.strathcom.com/image/show/960x_/56465779e2faf668c13a7f78.jpg">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/526x394/56465779e2faf668c13a7f78.jpg" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
								<li>
									<a href="http://photos.strathcom.com/image/show/960x_/5646577b9f40e368bb0c134f.jpg">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/526x394/5646577b9f40e368bb0c134f.jpg" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
								<li>
									<a href="http://photos.strathcom.com/image/show/960x_/5646577fb0431768c0b5a6c8.jpg">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/526x394/5646577fb0431768c0b5a6c8.jpg" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
								<li>
									<a href="http://photos.strathcom.com/image/show/960x_/56465782b0431768c0b5a6c9.jpg">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/526x394/56465782b0431768c0b5a6c9.jpg" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
							</ul>
						</div>
						<div class="image-carousel carousel" data-item-width="120">
							<ul class="slides">
								<li>
									<a href="#slide-1">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/120x90/564657759f40e368bb0c134d.jpg" width="120" height="90" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
								<li>
									<a href="#slide-2">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/120x90/56465779e2faf668c13a7f78.jpg" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
								<li>
									<a href="#slide-3">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/120x90/5646577b9f40e368bb0c134f.jpg" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
								<li>
									<a href="#slide-4">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/120x90/5646577fb0431768c0b5a6c8.jpg" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
								<li>
									<a href="#slide-5">
										<img itemprop="image" src="http://photos.strathcom.com/image/show/120x90/56465782b0431768c0b5a6c9.jpg" alt="2016 Chevrolet CRUZE LIMITED in Grande Prairie, Alberta">
									</a>
								</li>
							</ul>
						</div>
					</figure>

					<div class="product-description">
						<h2 itemprop="name">2016 Toyota 4Runner</h2>
						<h3 class="_bpcolordark">4Runner Trail Edition 4x4 w/6.1" display for backup camera, Bluetooth capability and navigation, USB audio input, steering wheel audio controls, 17" alloy rims, seats 7, moonroof, leather heated seats, power passenger chair/power driver chair with lumbar support and anti-theft system, 4-wheel crawl control, multi-terrain ABS, multi-terrain select, rear differential lock, sliding cargo area tray, black roof rails and hood scoop</h3>
					</div>

					<div class="product-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
						<strike class="retail-price">Retail: $60,092</strike>
						<span class="savings-price">You save $500
							<span class="price-breakdown">
								<strong>$60,092 Retail Price</strong>
								<br>= $500 Dealer Discount/Manufacturer Rebate
								<br>= $500 Total Savings
							</span>
						</span>
						<h2 class="price _bpcolor" itemprop="price" content="<?php print ( $price = rand(1, 99) . ',' . rand(100, 999) ); ?>">
							<span itemprop="priceCurrency" content="CAD">$</span><?php print $price; ?>
						</h2>
						<?php if ( 1 === rand( 0, 1 ) ): ?>
							<span class="in-stock-indicator"><?php echo rand( 1, 10 ); ?> vehicles in stock</span>
						<?php else: ?>
							<span class="in-stock-indicator -inactive">Out of stock</span>
						<?php endif; ?>
					</div>

					<div class="product-contact-form">
						<h5>We'll help you find the perfect vehicle</h5>
						<?php the_contact_form( 'minimal', 'Request More Info' ); ?>
					</div>

					<div class="product-tabs" data-toggle="tabs">
						<ul class="tabs-nav" role="tablist">
							<li><a href="#overview">Overview</a></li>
							<li><a href="#specifications">Specifications</a></li>
							<li><a href="#value-my-trade-in" class="active">Value My Trade In</a></li>
						</ul>
						<div class="tabs-content">
							<div class="tab-pane" id="overview" role="tabpanel">
								<h2>$500 Demo Savings!</h2>
								<p>The 2016 Toyota 4Runner is our mid-size, fully-capable SUV. Available in 5 or 7-passenger models, 4Runner is well-equipped, versatile and comfortable both on the road and off.</p>
								<p>Standard features include:</p>
								<ul>
									<li>4.0 L V6 Engine and One-Touch 4WD</li>
									<li>6.1" Touchscreen Display Audio</li>
									<li>USB Audio Input and Bluetooth® Capability</li>
									<li>Backup Camera</li>
									<li>Running Boards</li>
									<li>Roof Rails</li>
									<li>Towing Hitch and Trailer Sway Control</li>
								</ul>
								<p>This 4Runner has 2way remote starter, 3" lift kit, 3M tape (hood 18", side mirrors, fenders, door cups and bumper), front window tint, and rigid light bar.</p>
								<h4>Click Contact us or book a test drive, above for more information. For immediate assistance call toll free <a href="tel:+17804201111">780-420-1111</a></h4>
							</div>
							<div class="tab-pane" id="specifications" role="tabpanel">
								<div class="product-specification" role="tablist">
									<h4 role="tab" data-toggle="collapse" data-target="#specs-equipment" class="collapsed">Equipment</h4>
									<div role="tabpanel" class="collapse" id="specs-equipment">
										<ul class="spec-list">
											<li>Fuel Type: Regular unleaded</li>
											<li>MP3 player</li>
											<li>Front Ventilated disc brakes</li>
											<li>4 Door</li>
											<li>Front Shoulder Room: 1,391 mm</li>
											<li>Gross vehicle weight: 1,960 kg</li>
											<li>Tires: Speed Rating: S</li>
											<li>Tires: Profile: 60</li>
											<li>Spare Tire Mount Location: Inside under cargo</li>
											<li>Trip computer</li>
											<li>Urethane shift knob trim</li>
											<li>Vehicle Emissions: ULEV</li>
											<li>External temperature display</li>
											<li>Left rear passenger door type: Conventional</li>
											<li>Front suspension stabilizer bar</li>
											<li>Daytime running lights</li>
											<li>Rear door type: Trunk</li>
											<li>Right rear passenger door type: Conventional</li>
											<li>Coil rear spring</li>
											<li>Center Console: Full with covered storage</li>
											<li>Manual front air conditioning</li>
											<li>SiriusXM AM/FM/Satellite Radio</li>
											<li>Body-coloured bumpers</li>
											<li>Independent front suspension classification</li>
											<li>Overall Width: 1,796 mm</li>
											<li>Headlights off auto delay</li>
											<li>Digital Audio Input</li>
											<li>Rear Head Room: 963 mm</li>
											<li>Tire Pressure Monitoring System: Tire specific</li>
											<li>Remote power door locks</li>
											<li>Integrated roof antenna</li>
											<li>Audio controls on steering wheel</li>
											<li>Tires: Prefix: P</li>
											<li>Seatbelt pretensioners: Front</li>
											<li>Front Independent Suspension</li>
											<li>Driver and passenger knee airbags</li>
											<li>Bucket front seats</li>
											<li>Diameter of tires: 16.0"</li>
											<li>Regular front stabilizer bar</li>
											<li>Cupholders: Front and rear</li>
											<li>Braking Assist</li>
											<li>Anti-theft alarm system</li>
											<li>Compass</li>
											<li>Type of tires: AS</li>
											<li>Door pockets: Driver, passenger and rear</li>
											<li>In-Dash single CD player</li>
											<li>Interior air filtration</li>
											<li>Wheel Width: 6.5</li>
											<li>Rear Leg Room: 898 mm</li>
											<li>Privacy glass: Light</li>
											<li>Strut front suspension</li>
											<li>Tilt and telescopic steering wheel</li>
											<li>Door reinforcement: Side-impact door beam</li>
											<li>Audio system memory card slot</li>
											<li>Mobile hotspot internet access</li>
											<li>Rear Hip Room: 1,331 mm</li>
											<li>Front Hip Room: 1,346 mm</li>
											<li>SiriusXM Satellite Radio(TM)</li>
											<li>Dash trim: Cloth/metal-look</li>
											<li>OnStar Guidance</li>
											<li>Black grille w/chrome surround</li>
											<li>Fold forward seatback rear seats</li>
											<li>Metal-look center console trim</li>
											<li>Wheelbase: 2,685 mm</li>
											<li>Passenger Airbag</li>
											<li>Clock: In-radio display</li>
											<li>Driver airbag</li>
											<li>Max cargo capacity: 425 L</li>
											<li>Bluetooth wireless phone connectivity</li>
											<li>Instrumentation: Low fuel level</li>
											<li>Manual child safety locks</li>
											<li>Fuel Capacity: 59 L</li>
											<li>Cargo area light</li>
											<li>Urethane steering wheel trim</li>
											<li>Torsion beam rear suspension</li>
											<li>Power remote driver mirror adjustment</li>
											<li>Engine immobilizer</li>
											<li>Rear seats center armrest</li>
											<li>Dusk sensing headlights</li>
											<li>Rear Shoulder Room: 1,369 mm</li>
											<li>Audio system security</li>
											<li>Front Leg Room: 1,074 mm</li>
											<li>Variable intermittent front wipers</li>
											<li>ABS and Driveline Traction Control</li>
											<li>Steel spare wheel rim</li>
											<li>Overall Length: 4,597 mm</li>
											<li>Coil front spring</li>
											<li>Speed Sensitive Audio Volume Control</li>
											<li>Remote activated exterior entry lights</li>
											<li>Tires: Width: 215 mm</li>
											<li>Wheel Diameter: 16</li>
											<li>Radio Data System</li>
											<li>Fuel Consumption: City: 9.4 L/100 km</li>
											<li>Power windows</li>
											<li>Fuel Consumption: Highway: 6.6 L/100 km</li>
											<li>Dual vanity mirrors</li>
											<li>Two 12V DC power outlets</li>
											<li>Overall height: 1,476 mm</li>
											<li>Curb weight: 1,399 kg</li>
											<li>4-wheel ABS Brakes</li>
											<li>1st and 2nd row curtain head airbags</li>
											<li>Power remote passenger mirror adjustment</li>
											<li>Stability control with anti-roll control</li>
											<li>Speed-proportional electric power steering</li>
											<li>Semi-independent rear suspension</li>
											<li>Rear center seatbelt: 3-point belt</li>
											<li>Floor mats: Carpet front and rear</li>
											<li>Total Number of Speakers: 6</li>
											<li>Front reading lights</li>
											<li>Rear bench</li>
											<li>Front Head Room: 998 mm</li>
											<li>Side airbag</li>
											<li>Tachometer</li>
											<li>Premium cloth seat upholstery</li>
											<li>Suspension class: Regular</li>
										</ul>
									</div>

									<h4 role="tab" data-toggle="collapse" data-target="#specs-fuel-economy" class="collapsed">Fuel Economy</h4>
									<div role="tabpanel" class="collapse" id="specs-fuel-economy">
										<dl class="spec-list">
											<dt>Fuel economy - combined (L/100 km)</dt>
												<dd>8.1</dd>
											<dt>Recommended fuel</dt>
												<dd>Regular unleaded</dd>
											<dt>Fuel tank capacity (L)</dt>
												<dd>59</dd>
											<dt>Fuel economy - highway (L/100 km)</dt>
												<dd>7</dd>
											<dt>Fuel economy - city (L/100 km)</dt>
												<dd>9</dd>
										</dl>
									</div>

									<h4 role="tab" data-toggle="collapse" data-target="#specs-warranty" class="collapsed">Warranty *</h4>
									<div role="tabpanel" class="collapse" id="specs-warranty">
										<dl class="spec-list">
											<dt>Scheduled maintenance months</dt>
												<dd>24</dd>
											<dt>Scheduled maintenance distance (km)</dt>
												<dd>48,000</dd>
											<dt>Roadside assistance distance (km)</dt>
												<dd>160,000</dd>
											<dt>Basic distance (km)</dt>
												<dd>60,000</dd>
											<dt>Roadside assistance months</dt>
												<dd>60</dd>
											<dt>Basic months</dt>
												<dd>36</dd>
										</dl>
									</div>

									<h4 role="tab" data-toggle="collapse" data-target="#specs-capacity" class="collapsed">Capacity</h4>
									<div role="tabpanel" class="collapse" id="specs-capacity">
										<dl class="spec-list">
											<dt>Maximum interior cargo volume (L)</dt>
												<dd>425</dd>
											<dt>Seating capacity</dt>
												<dd>5</dd>
											<dt>Passenger volume (L)</dt>
												<dd>2,679</dd>
										</dl>
									</div>

									<div class="disclaimer">
										<p>* Please note that all the above options, with the exception of 'Installed Options', are drawn from the generic 'base' version of the vehicle. The options listed might not exactly match this specific vehicle.</p>
										<p>* Manufacturer warranty may not be available for pre-owned vehicles, please inquire with dealer about availability for this vehicle.</p>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="value-my-trade-in" role="tabpanel">
								<form name="value_tradein" action="#" method="post" class="value-tradein" role="form">
									<fieldset class="contact-details">
										<div class="form-group required">
											<label for="ti_name">Name</label>
											<input class="form-control" id="ti_name" name="name" type="text" placeholder="Enter your name">
										</div>
										<div class="form-group required">
											<label for="id_email">Email</label>
											<input class="form-control" id="id_email" name="email" type="email" placeholder="you@example.com">
										</div>
										<div class="form-group required">
											<label for="id_primary_phone">Phone</label>
											<input class="form-control" id="id_primary_phone" name="primary_phone" type="text" placeholder="555-555-5555">
										</div>
									</fieldset>
									<fieldset class="vehicle-details">
										<div class="form-group">
											<label for="vehicle_year">Customer Vehicle Year</label>
											<input class="form-control" id="vehicle_year" name="vehicle_year" type="text">
										</div>
										<div class="form-group">
											<label for="vehicle_make">Vehicle Make</label>
											<input class="form-control" id="vehicle_make" name="vehicle_make" type="text">
										</div>
										<div class="form-group">
											<label for="vehicle_model">Vehicle Model</label>
											<input class="form-control" id="vehicle_model" name="vehicle_model" type="text">
										</div>
										<div class="form-group">
											<label for="vehicle_vin">Vehicle VIN</label>
											<input class="form-control" id="vehicle_vin" name="vehicle_vin" type="text">
										</div>
										<div class="form-group">
											<label for="vehicle_transmission">Vehicle Transmission</label>
											<select class="form-control" id="vehicle_transmission" name="vehicle_transmission">
												<option value="">Please choose...</option>
												<option value="1">1</option>
											</select>
										</div>
										<div class="form-group">
											<label for="vehicle_cylinders">Vehicle Cylinders</label>
											<select class="form-control" id="vehicle_cylinders" name="vehicle_cylinders">
												<option value="">Please choose...</option>
												<option value="1">1</option>
											</select>
										</div>
										<div class="form-group">
											<label for="vehicle_drivetrain">Vehicle Drive Train</label>
											<select class="form-control" id="vehicle_drivetrain" name="vehicle_drivetrain">
												<option value="">Please choose...</option>
												<option value="1">1</option>
											</select>
										</div>
										<div class="form-group">
											<label for="vehicle_trim">Vehicle Trim</label>
											<input class="form-control" id="vehicle_trim" name="vehicle_trim" type="text">
										</div>
										<div class="form-group">
											<label for="vehicle_odometer">Vehicle Odometer</label>
											<input class="form-control" id="vehicle_odometer" name="vehicle_odometer" type="text">
										</div>
									</fieldset>
									<fieldset class="vehicle-comments">
										<div class="form-group optional">
											<label for="ti_message">Comments, Questions?</label>
											<textarea class="form-control" cols="40" id="ti_message" name="message" rows="10"></textarea>
										</div>
										<div class="form-disclaimer optional">
											<label class="checkbox">
												<input type="checkbox" name="casl_opt_in">
												<span>I wish to receive periodical offers, newsletter, safety and recall updates from Mayfield Toyota. Consent can be withdrawn at any time.</span>
											</label>
										</div>
										<input type="submit" value="Appraise My Trade" class="btn btn-primary">
									</fieldset>
								</form>
							</div>
						</div>
					</div>

					<div class="product-info">
						<dl class="spec-list alternating" itemprop="description">
							<dt>Exterior Colour</dt>
								<dd itemprop="color">Silver</dd>
							<dt>Interior Colour</dt>
								<dd>Black</dd>
							<dt>Engine</dt>
								<dd>1.8L I4</dd>
							<dt>Transmission</dt>
								<dd>6 Spd Manual</dd>
							<dt>Odometer</dt>
								<dd>10 kms</dd>
							<dt>Stock #</dt>
								<dd itemprop="productid">testid<?php //print rand(10000, 99999); /*16CR1298*/ ?></dd>
							<dt>Dealership</dt>
								<dd>Doug Marshall Chevrolet Corvette Cadillac</dd>
						</dl>
					</div>

				</main>

				<?php include '../partials-common/similar-products.php'; ?>
				<?php include '../partials-common/map.php'; ?>

				<div class="disclaimer">
					<p>* Although every attempt is made to ensure the accuracy of the data above, due to the possibility of human error, we cannot guarantee the accuracy of the displayed information, the availability of this vehicle, or the accuracy of its photo or "stock photo." Such information may not reflect exact vehicle colour, trim, options, price or other specifications. Please contact the dealership for verification or if you would like more information on this vehicle.</p>
					<p>* Prices for the provinces of Ontario, Alberta and British Columbia include dealer-installed accessories, optional equipment physically attached to the vehicle, transportation charges and any applicable administration fees, but do not include taxes, insurance or licensing fees. For all other provinces (excluding Quebec), prices exclude taxes, insurance, licensing and other applicable fees. Price may not include dealer installed options, accessories, administration fees and other dealer charges.</p>
					<p>All prices are in Canadian Dollars unless otherwise stated.</p>
				</div>

			</div>
		</div>
	</div>

<?php include '../partials-common/footer.php'; ?>
