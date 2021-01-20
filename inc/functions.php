<?php 

// Demo Content

function wccheckerDemoContent() {
	
?>

<div class="wrap">

	<h1><?php esc_html_e( 'Install Demo', 'wcchecker' ) ?></h1>

	<p><?php esc_html_e( 'Click Install Demo Button, then wait. After the installation process is complete, the demo content will be added to your panel.', 'wcchecker' ); ?></p>

	<?php

		if ( isset($_POST['wcc_import_field']) && !wp_verify_nonce($_POST['wcc_import_field'], __FILE__) ) {

			$keys = array('code01','code02','code03','KbHk111');

			foreach($keys as $key) {

				$my_post = array(
					'post_title'    => $key,
					'post_type'    => 'sc',
					'post_status'   => 'publish',
					'post_author'   => 1,
				);
				 
				$result = wp_insert_post( $my_post );

				if($key == 'code02') {

					update_post_meta( $result, 'sc_date', '2025-01-31');

				} 

				if($key == 'code01') {

					update_post_meta( $result, 'sc_date', '2021-01-01');

				} 

			}

			echo '<div id="message" class="updated notice is-dismissible"><p>'.__('Demo installation completed successfully.', 'wcchecker' ).'</p></div>';

		}

	?>

	<form method="post">

		<?php wp_nonce_field( 'wcc_import', 'wcc_import_field'); ?>

		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Install', 'wcchecker' ); ?>"></p>

	</form>

</div>

<?php }