/* globals jQuery, _strathcomCarouselArchiveExports */
/* exported strathcomCarouselArchive */
var strathcomCarouselArchive = ( function( $ ) {
	var self = {
		saveText: 'Archive'
	};

	if ( 'undefined' !== typeof _strathcomCarouselArchiveExports ) {
		$.extend( self, _strathcomCarouselArchiveExports );
	}

	self.init = function() {

		$( document ).ready( function() {
			self.postStatusSelect = 'select#post_status';

			if ( 0 >= $( self.postStatusSelect ).length ) {
				return;
			}
			self.readyToDelete = false;

			self.archivedStatusOption = '#archived-status';
			self.postStatusDisplay = '#post-status-display';
			self.warning = '#archive-warning';
			self.cancelButton = '#archive-cancel';
			self.proceedButton = '#archive-proceed';
			self.publishButton = 'input#publish';
			self.deleteLink = '#delete-action .submitdelete.deletion';
			self.deleteWarning = '#delete-warning';
			self.cancelDeleteButton = '#delete-cancel';
			self.proceedDeleteButton = '#delete-proceed';
			self.savePostStatusButton = '.save-post-status';
			self.okButton = 'input#save-post';
			self.storepostStatusSelect = $( self.postStatusSelect ).val().toLowerCase();
			self.storePostStatusString = $( self.postStatusDisplay ).html();

			/*
			 * Hack to add our Post Status to the Post Status <select>
			 * in the Publish metabox.
			 */
			$( self.postStatusSelect ).append( $( self.archivedStatusOption ) );

			/*
			 * On Page Load, if the post status is already "Archived"...
			 */
			if ( self.postStatus === self.archivedStatus.toLowerCase() ) {

				// Set the Post Status label to "Archived".
				$( '.misc-pub-post-status label' ).append( '<span id="post-status-display">&nbsp;' + self.archivedStatus + '</span>' );

				// Set the Post Status <select> to "Archived".
				$( self.postStatusSelect ).val( self.archivedStatus );

				// Update Posts Status data.
				$( self.okButton ).prop( 'value', self.saveText );

				// Set the "Save Draft"-type button to "Archive".
				self.updateButtons();
			}

			/*
			 * When the save post status button is clicked, check the select value
			 * and act accordingly.
			 */
			$( self.savePostStatusButton ).click( function() {
				if ( $( self.postStatusSelect ).val() === self.archivedStatus.toLowerCase() ) {

					// Show Warning box.
					$( self.warning ).slideDown();

					self.updateButtons();
					self.disableButtons();
				} else {

					// Hide Warning box.
					$( self.warning ).slideUp();
					self.resetButtons();
				}
			});

			$( self.cancelButton ).click( function( e ) {
				self.handleCancel();
				e.preventDefault();
			});

			/*
			 * If the proceedButton is clicked,
			 * enable the Publish button.
			 */
			$( self.proceedButton ).click( function( e ) {

				// Hide Warning box.
				$( self.warning ).slideUp();

				if ( $( self.okButton ).length ) {
					$( self.okButton ).prop( 'value', self.saveText );
				} else {
					$( self.publishButton ).prop( 'value', self.saveText );
				}

				self.enableButtonsArchive();
				e.preventDefault();
			});

			/*
			 * Throw a warning when attempting to delete.
			 */
			if ( self.postStatus === self.archivedStatus.toLowerCase() ) {
				$( self.deleteLink ).click( function( e ) {
					if ( true !== self.readyToDelete ) {
						e.preventDefault();

						// Show Delete Warning box.
						$( self.deleteWarning ).slideDown();
					} else {
						$( self.deleteLink ).trigger( 'click.edit-post' );
					}
				});
			}

			/*
			 * Cancel Deletion.
			 */
			$( self.cancelDeleteButton ).click( function( e ) {
				e.preventDefault();
				$( self.deleteWarning ).slideUp();
			});

			/*
			 * Proceed with Deletion.
			 */
			$( self.proceedDeleteButton ).click( function( e ) {
				e.preventDefault();
				$( self.deleteWarning ).slideUp();
				self.readyToDelete = true;
				$( self.deleteLink ).addClass( 'bordered' );
			});
		});
	};

	self.updateButtons = function() {
		$( self.okButton ).on( 'click', function() {
			setTimeout( function() {
				$( self.okButton ).prop( 'value', self.saveText );
			}, 5 );
		} );
	};

	/*
	 * Disable the Buttons.
	 */
	self.disableButtons = function() {
		$( self.okButton ).attr( 'disabled', 'disabled' );
		$( self.publishButton ).attr( 'disabled', 'disabled' );
	};

	/*
	 * Disable Buttons.
	 * If the "Save Draft"-type button is found, set it to blue.
	 */
	self.resetButtons = function() {
		if ( $( self.okButton ).length ) {
			$( self.publishButton ).removeClass( 'button-secondary' ).addClass( 'button-primary' );
			$( self.okButton ).removeAttr( 'disabled' ).removeClass( 'button-primary' ).addClass( 'button-secondary' );
		}
		$( self.publishButton ).removeAttr( 'disabled' );
	};

	/*
	 * When the Cancel Archiving button is clicked,
	 * restore original Post Status settings and
	 * hide the warning box.
	 */
	self.handleCancel = function() {

		// Restore original settings
		$( self.postStatusSelect ).val( self.storepostStatusSelect );
		$( self.postStatusDisplay ).html( '&nbsp;' + self.storePostStatusString );

		// Hide Warning box.
		$( self.warning ).slideUp();

		self.resetButtons();
	};

	/*
	 * Hide the Warning box and Re-enable the Publish button.
	 */
	self.enableButtonsArchive = function() {

		if ( $( self.okButton ).length ) {

			// Re-enable the Publish button.
			$( self.publishButton ).removeClass( 'button-primary' ).addClass( 'button-secondary' );
			$( self.okButton ).removeAttr( 'disabled' ).removeClass( 'button-secondary' ).addClass( 'button-primary' );
		}
		$( self.publishButton ).removeAttr( 'disabled' );
	};

	return self;
})( jQuery );
