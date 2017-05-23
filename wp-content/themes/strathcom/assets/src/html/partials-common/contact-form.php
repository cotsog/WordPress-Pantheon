<?php function the_contact_form( $size = '', $submit_button_text = 'Submit' ) { ?>
<form name="contact_form" action="#" method="post" class="contact-form <?php echo $size; ?>" role="form">

	<fieldset class="contact-details">

		<legend>Contact Details</legend>

		<?php if ( 'compact' === $size || 'minimal' === $size ): ?>

			<div class="form-group required">
				<label for="id_name">Your Name</label>
				<input class="form-control" id="id_name" name="name" type="text" placeholder="Enter your name">
			</div>

		<?php else: ?>

			<div class="form-group required">
				<label for="id_first_name">First Name</label>
				<input class="form-control" id="id_first_name" name="first_name" type="text">
			</div>

			<div class="form-group required">
				<label for="id_last_name">Last Name</label>
				<input class="form-control" id="id_last_name" name="last_name" type="text">
			</div>

		<?php endif; ?>

		<div class="form-group required">
			<label for="id_email">Email</label>
			<input class="form-control" id="id_email" name="email" type="email" placeholder="you@example.com">
		</div>

		<div class="form-group required">
			<label for="id_primary_phone">Primary Phone</label>
			<input class="form-control" id="id_primary_phone" name="primary_phone" type="text" placeholder="555-555-5555">
		</div>

	</fieldset>

	<fieldset class="contact-comments">

		<legend>Comments/Questions</legend>

			<div class="form-group optional">
				<label for="id_message">Message</label>
				<textarea class="form-control" cols="40" id="id_message" name="message" rows="10"></textarea>
			</div>

			<input type="submit" value="<?php echo $submit_button_text; ?>" class="btn btn-primary">

			<div class="form-disclaimer optional">
				<label class="checkbox">
					<input type="checkbox" id="id_casl_opt_in" name="casl_opt_in">
					<?php if ( 'compact' === $size || 'minimal' === $size ): ?>
						<span>I agree to receive periodical offers, newsletter, safety and recall updates from Mayfield Toyota. Consent can be withdrawn at any time.</span>
					<?php else: ?>
						<span>I wish to receive ongoing communication for exclusive discounts, promotional offers &amp; contest details. By checking the box, I agree to receive commercial electronic messages and educational content via email from Doug Marshall Chevrolet Corvette Cadillac.</span>
						<span>You may withdraw your consent at any time.</span>
					<?php endif; ?>
				</label>
			</div>

	</fieldset>

</form>
<?php } ?>
