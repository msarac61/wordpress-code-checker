<?php

// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Create New Post Type

function wccheckerPostType() {

	$labels = array(
		'name'                  => _x( 'Security Code(s)', 'Post Type General Name', 'wcchecker' ),
		'singular_name'         => _x( 'Security Code(s)', 'Post Type Singular Name', 'wcchecker' ),
		'menu_name'             => __( 'Security Code(s)', 'wcchecker' ),
		'name_admin_bar'        => __( 'Security Code(s)', 'wcchecker' ),
	);

	$args = array(
		'label'                 => __( 'Security Code(s)', 'wcchecker' ),
		'labels'                => $labels,
		'supports'              => array( 'title'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => false,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-post-status',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
	);

	register_post_type( 'sc', $args );

}

add_action( 'init', 'wccheckerPostType', 0 );