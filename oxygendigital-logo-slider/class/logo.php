<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Handles displays logo custom post.
 *
 * @package logo-carousel-free
 * @since 3.0
 */
class SPLC_Logo {

	/**
	 * The single instance of the class.
	 *
	 * @var self
	 * @since 3.0
	 */
	private static $_instance = null;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since 3.0
	 * @static
	 * @return self Main instance.
	 */
	public static function getInstance() {
		if ( ! self::$_instance ) {
			self::$_instance = new SPLC_Logo();
		}

		return self::$_instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Registers the custom post type
	 */
	public function register_post_type() {
		if ( post_type_exists( 'wpl_logo_carousel' ) ) {
			return;
		}

		$args_post_type = array(
			'label'               => __( 'Logo', 'logo-carousel-free' ),
			'description'         => __( 'Logo carousel post type', 'logo-carousel-free' ),
			'exclude_from_search' => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 20,
			'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNy4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iMzAwcHgiIGhlaWdodD0iMzAwcHgiIHZpZXdCb3g9IjAgMCAzMDAgMzAwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAzMDAgMzAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnPg0KCTxyZWN0IHg9IjIuNCIgeT0iNTUuMTE5IiBmaWxsPSIjQTBBNUFBIiB3aWR0aD0iNTguMzczIiBoZWlnaHQ9IjE4OS41OTUiLz4NCgk8cmVjdCB4PSIyMzkuNjI3IiB5PSI1NS4xMTkiIGZpbGw9IiNBMEE1QUEiIHdpZHRoPSI1OC4zNzMiIGhlaWdodD0iMTg5LjU5NSIvPg0KCTxyZWN0IHg9Ijc1LjI0OSIgeT0iMjcuMSIgZmlsbD0iI0EwQTVBQSIgd2lkdGg9IjE0OS45MDIiIGhlaWdodD0iMjQ2LjEiLz4NCjwvZz4NCjwvc3ZnPg0K',
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'has_archive'         => false,
			'can_export'          => true,
			'rewrite'             => array( 'slug' => '' ),
			'query_var'           => false,
			'supports'            => array(
				'title',
				'thumbnail',
			),
			'labels'              => array(
				'name'                  => __( 'All Logos', 'logo-carousel-free' ),
				'singular_name'         => __( 'Logo', 'logo-carousel-free' ),
				'menu_name'             => __( 'Logo Carousel', 'logo-carousel-free' ),
				'add_new'               => __( 'Add New', 'logo-carousel-free' ),
				'add_new_item'          => __( 'Add New', 'logo-carousel-free' ),
				'edit'                  => __( 'Edit', 'logo-carousel-free' ),
				'edit_item'             => __( 'Edit', 'logo-carousel-free' ),
				'new_item'              => __( 'New Logo', 'logo-carousel-free' ),
				'view'                  => __( 'View Logo', 'logo-carousel-free' ),
				'view_item'             => __( 'View Logo', 'logo-carousel-free' ),
				'all_items'             => __( 'All Logos', 'logo-carousel-free' ),
				'search_items'          => __( 'Search Logo', 'logo-carousel-free' ),
				'not_found'             => __( 'No Logo Found', 'logo-carousel-free' ),
				'not_found_in_trash'    => __( 'No Logo Found in Trash', 'logo-carousel-free' ),
				'parent'                => __( 'Parent Logos', 'logo-carousel-free' ),
				'featured_image'        => __( 'Logo Image', 'logo-carousel-free' ),
				'set_featured_image'    => __( 'Set Logo', 'logo-carousel-free' ),
				'remove_featured_image' => __( 'Remove logo image', 'logo-carousel-free' ),
				'use_featured_image'    => __( 'Use as logo image', 'logo-carousel-free' ),
			),
		);

		$args_post_type = apply_filters( 'wpl_lc_register_logo_post_type', $args_post_type );

		register_post_type( 'wpl_logo_carousel', $args_post_type );
	}

}
