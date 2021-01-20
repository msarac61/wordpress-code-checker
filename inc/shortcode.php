<?php

// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wccheckerCompareDate($current_date, $end_date)
{
    $current = strtotime($current_date);
    $end = strtotime($end_date);
    if ($current - $end > 0) {
        return 1;
    } else {
        return 0;
    }
}

// Generate Shortcode

function wccheckerShortcode() {

	// All Keys

	$code = array();

	$args = array(
		'post_type' => 'sc',
		'posts_per_page' => '-1',
	);
	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) :

	while ( $the_query->have_posts() ) : $the_query->the_post();

	$code[] = get_the_title();

	endwhile;
	endif;
	wp_reset_postdata();

	// Shortcode Result(s)

	$result = '';

		if(isset($_POST['product_code'])) {

			if (isset( $_POST['wcchecker_field'] ) || wp_verify_nonce( $_POST['wcchecker_field'], 'wccheckerShortcode' )) {

				if (in_array(sanitize_text_field($_POST['product_code']), $code)) {

					$post = get_page_by_title(sanitize_text_field($_POST['product_code']), OBJECT, 'sc' );

					$post_end_time = get_post_meta($post->ID, "sc_date", true);

					$current_time = current_time('Y-m-d');

					$date_result =  wccheckerCompareDate($post_end_time,$current_time);

					if($post_end_time) {

						if($date_result == '0') {

							$result .= '<div class="wcchecker-alert wcchecker-alert-warning">'.wcchecker('expired_time').'</div>';

						} else {

							$result .= '<div class="wcchecker-alert wcchecker-alert-success">'.wcchecker('pending_time').' <span class="wcchecker-end-time">'. __( 'End Time : ', 'wcchecker' ).' '.$post_end_time.'</span></div>';

						}

					} else {

						$result .= '<div class="wcchecker-alert wcchecker-alert-success">'.wcchecker('success_value').'</div>';

					}

				 } else {

					$result .= '<div class="wcchecker-alert wcchecker-alert-danger">'.wcchecker('error_value').'</div>';

				}

			} else {

					$result .= '<div class="wcchecker-alert wcchecker-alert-danger">'.wcchecker('error_value').'</div>';

			}

		}

		$result .= '<div class="wcchecker-form">';

			$result .= '<form method="post">';

				$result .= wp_nonce_field( 'wccheckerShortcode', 'wcchecker_field' );

				if(isset($_POST['product_code'])) {

					$result .= '<div class="wcchecker-left"><input type="text" name="product_code" placeholder="'.wcchecker('placeholder_value').'" value="'.sanitize_text_field($_POST['product_code']).'" required autocomplete="off"></div>';

				} else {

					$result .= '<div class="wcchecker-left"><input type="text" name="product_code" placeholder="'.wcchecker('placeholder_value').'" required autocomplete="off"></div>';
				}

				$result .= '<div class="wcchecker-right"><input type="submit" value="'.wcchecker('send_button_value').'"></div>';

				$result .= '<div class="wcchecker-clearfix"></div>';

			$result .= '</form>';

		$result .= '</div>';

	return $result;

}

add_shortcode( 'wcchecker', 'wccheckerShortcode' );