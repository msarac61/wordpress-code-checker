<?php 

// General Random Key Code Functions

function wcc_random_code($type = 'alnum', $len = 8) {

	switch ($type)
	{
		case 'alnum':
		case 'numeric':
		case 'nozero':
		case 'alpha':
			switch ($type)
			{
				case 'alpha':
					$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
				case 'alnum':
					$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
				case 'numeric':
					$pool = '0123456789';
					break;
				case 'nozero':
					$pool = '123456789';
					break;
			}
			return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
		case 'md5':
			return md5(uniqid(mt_rand()));
		case 'sha1':
			return sha1(uniqid(mt_rand(), TRUE));
	}

}

// Demo Content & Create Content

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

	<h2><?php esc_html_e( 'Generate Random Code', 'wcchecker' ) ?></h2>

	<p><?php esc_html_e( 'Random Code Generation According to Your Criteria.', 'wcchecker' ); ?></p>

	<?php

		if ( isset($_POST['wccRandomFields']) && !wp_verify_nonce($_POST['wccRandomFields'], __FILE__) ) {

			for($i = '0'; $i < sanitize_text_field($_POST['code_quantity']); $i++) {
				
				$post_title = wcc_random_code(sanitize_text_field($_POST['code_type']),sanitize_text_field($_POST['code_length']));

				$my_post = array(
					'post_title'    => $post_title,
					'post_type'    => 'sc',
					'post_status'   => 'publish',
					'post_author'   => 1,
				);
				 
				$result = wp_insert_post( $my_post );

			}

			echo '<div id="message" class="updated notice is-dismissible"><p>'.__('Codes Created Successfully.', 'wcchecker' ).'</p></div>';

		}
	?>

	<form method="post">

		<?php wp_nonce_field( 'wccRandom', 'wccRandomFields'); ?>

			<table class="form-table">
				<tr>
					<th><label for="code_length"><?php esc_html_e( 'Code Length', 'wcchecker' ); ?></label></th>
					<td><input type="text" name="code_length" id="code_length" value="5" class="regular-text" required></td>
				</tr>

				<tr>
					<th><label for="code_length"><?php esc_html_e( 'Code Quantity', 'wcchecker' ); ?></label></th>
					<td><input type="text" name="code_quantity" id="code_quantity" value="1" class="regular-text" required></td>
				</tr>

				<tr>
					<th><label for="code_length"><?php esc_html_e( 'Code Type', 'wcchecker' ); ?></label></th>
					<td>
					<select name="code_type" required>
						<option value="alpha"><?php esc_html_e( 'Alphabetical Only', 'wcchecker' ); ?></option>
						<option value="alnum"><?php esc_html_e( 'Alphabetical + Numeric', 'wcchecker' ); ?></option>
						<option value="numeric"><?php esc_html_e( 'Numeric Only', 'wcchecker' ); ?></option>
						<option value="nozero"><?php esc_html_e( 'Numeric Only (No Zero)', 'wcchecker' ); ?></option>
					</select>
					</td>
				</tr>

			</table>

			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Create', 'wcchecker' ); ?>"></p>

		</form>

</div>

<?php }