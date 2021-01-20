<?php

	// Config Wcc Metabox

	function wccheckerMetaBox() {

		$wccTypes = array( 'sc' ); // Post Type Name

		foreach ( $wccTypes as $wccType ) {

			add_meta_box('wccTypesection', __( 'Wcc Settings', 'wcchecker' ), 'wccheckerMetaBox_callback', $wccType);

		 }

	}

	add_action( 'add_meta_boxes', 'wccheckerMetaBox' );

	// Create Wcc Metabox Input

	function wccheckerMetaBox_callback( $post ) {

		wp_nonce_field( 'wccheckerMetaBox_update', 'wccheckerMetaBox_nonce' );

		$value = get_post_meta( $post->ID, 'sc_date', true );

		echo '<table class="form-table">';

			echo '<tr valign="top">';

				echo '<th scope="row"><label for="wccField">'.__( 'End Time', 'wcchecker' ).'</th> ';

				echo '<td><input type="date" id="wccField" name="wccField" value="' . esc_attr( $value ) . '"></td>';

			echo '</tr>';

		echo '</table>';

	}

	// Metabox Wcc Field Update

	function wccheckerMetaBox_update( $post_id ) {

		 if ( ! isset( $_POST['wccheckerMetaBox_nonce'] ) ) {
			return;
		 }

		 if ( ! wp_verify_nonce( $_POST['wccheckerMetaBox_nonce'], 'wccheckerMetaBox_update' ) ) {
			return;
		 }

		 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		 }

		 // Check the user's permissions.
		 if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		 } else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		 }

		 if ( ! isset( $_POST['wccField'] ) ) {
			return;
		 }

		 $wcc_data = sanitize_text_field( $_POST['wccField'] );

		 update_post_meta( $post_id, 'sc_date', $wcc_data );

	}

	add_action( 'save_post', 'wccheckerMetaBox_update' );

?>