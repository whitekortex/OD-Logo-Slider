<?php
/**
 * This file render the shortcode to the frontend
 *
 * @package logo-carousel-free
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Logo Carousel - Shortcode Render class
 *
 * @since 3.0
 */
if ( ! class_exists( 'SPLC_Shortcode_Render' ) ) {
	class SPLC_Shortcode_Render {
		/**
		 * @var SPLC_Shortcode_Render single instance of the class
		 *
		 * @since 3.0
		 */
		protected static $_instance = null;


		/**
		 * Main SPLC Instance
		 *
		 * @since 3.0
		 * @static
		 * @return self Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * SPLC_Shortcode_Render constructor.
		 */
		public function __construct() {
			add_shortcode( 'logocarousel', array( $this, 'sp_logo_carousel_render' ) );
		}

		public function sp_logo_carousel_render( $attributes ) {
			extract(
				shortcode_atts(
					array( 'id' => '' ),
					$attributes,
					'logocarousel'
				)
			);
			$post_id  = $attributes['id'];
			$ps_lc_id = sp_lc_get_unique();

			$args = new WP_Query(
				array(
					'post_type'      => 'wpl_logo_carousel',
					'orderby'        => get_post_meta( $post_id, 'lc_logos_order_by', true ),
					'order'          => get_post_meta( $post_id, 'lc_logos_order', true ),
					'posts_per_page' => intval( get_post_meta( $post_id, 'lc_number_of_total_logos', true ) ),
				)
			);

			$column_number        = intval( get_post_meta( $post_id, 'lc_number_of_column', true ) );
			$column_number_dt     = intval( get_post_meta( $post_id, 'lc_number_of_column_dt', true ) );
			$column_number_smdt   = intval( get_post_meta( $post_id, 'lc_number_of_column_smdt', true ) );
			$column_number_tablet = intval( get_post_meta( $post_id, 'lc_number_of_column_tablet', true ) );
			$column_number_mobile = intval( get_post_meta( $post_id, 'lc_number_of_column_mobile', true ) );

			$nav            = $this->get_meta( $post_id, 'lc_show_navigation', 'true' );
			$dots           = $this->get_meta( $post_id, 'lc_show_pagination_dots', 'true' );
			$auto_play      = $this->get_meta( $post_id, 'lc_auto_play', 'true' );
			$pause_on_hover = $this->get_meta( $post_id, 'lc_pause_on_hover', 'true' );
			$swipe          = $this->get_meta( $post_id, 'lc_touch_swipe', 'true' );
			$draggable      = $this->get_meta( $post_id, 'lc_mouse_draggable', 'true' );
			$logo_border    = $this->get_meta( $post_id, 'lc_logo_border', 'true' );
			$rtl            = $this->get_meta( $post_id, 'lc_logo_rtl', 'false' );

			$autoplay_speed   = get_post_meta( $post_id, 'lc_auto_play_speed', true );
			$pagination_speed = get_post_meta( $post_id, 'lc_scroll_speed', true );
			$nav_color        = get_post_meta( $post_id, 'lc_nav_arrow_color', true );
			$dots_color       = get_post_meta( $post_id, 'lc_pagination_color', true );
			$brand_color      = get_post_meta( $post_id, 'lc_brand_color', true );

			wp_enqueue_style( 'sp-lc-slick' );
			wp_enqueue_style( 'sp-lc-font-awesome' );
			wp_enqueue_style( 'sp-lc-style' );
			// Enqueue Script.
			wp_enqueue_script( 'sp-lc-slick-js' );
			wp_enqueue_script( 'sp-lc-script' );

			$output  = '';
			$output .= '<style type="text/css">';
			if ( $logo_border == 'true' ) {
				$output .= 'div#logo-carousel-free-' . $post_id . '.logo-carousel-free .wpl-logo:hover{
					border: 1px solid ' . $brand_color . ';
				}';
			} else {
				$output .= 'div#logo-carousel-free-' . $post_id . '.logo-carousel-free .wpl-logo{
					border: none;
				}';
			}

			if ( $dots == 'true' ) {
				$output .= 'div#logo-carousel-free-' . $post_id . '.logo-carousel-free.logo-carousel-free-free-area ul.slick-dots li button{
					background-color: ' . $dots_color . '; 
				}
				div#logo-carousel-free-' . $post_id . '.logo-carousel-free.logo-carousel-free-free-area ul.slick-dots li.slick-active button{background-color: ' . $brand_color . '; }
				';
			}
			if ( $nav == 'true' ) {
				$output .= 'div#logo-carousel-free-' . $post_id . '.logo-carousel-free.logo-carousel-free-free-area .slick-prev,
				div#logo-carousel-free-' . $post_id . '.logo-carousel-free.logo-carousel-free-free-area .slick-next {
					color: ' . $nav_color . ';
				}
				div#logo-carousel-free-' . $post_id . '.logo-carousel-free.logo-carousel-free-free-area .slick-prev:hover,
				div#logo-carousel-free-' . $post_id . '.logo-carousel-free.logo-carousel-free-free-area .slick-next:hover{
					background-color: ' . $brand_color . ';
					color: #fff;
				}';
			}
			$output     .= '</style>';
			$output     .= "<div id='logo-carousel-free-$post_id' class=\"logo-carousel-free logo-carousel-free-free-area\">";
				$output .= '<div id="splc-wrapper-' . $ps_lc_id . '" class="splc-wrapper" data-slick=\'{ "arrows":' . $nav . ', "autoplay":' . $auto_play . ', "autoplaySpeed":' . $autoplay_speed . ', "dots":' . $dots . ', "infinite":true, "speed":' . $pagination_speed . ', "pauseOnHover":' . $pause_on_hover . ', "slidesToScroll":5, "slidesToShow":' . $column_number . ', "responsive":[ { "breakpoint":1280, "settings": { "slidesToShow":' . $column_number_dt . ' } }, { "breakpoint":980, "settings":{ "slidesToShow":' . $column_number_smdt . ' } }, { "breakpoint":736, "settings": { "slidesToShow":' . $column_number_tablet . ' } }, {"breakpoint":480, "settings":{ "slidesToShow":' . $column_number_mobile . ' } } ], "rtl":' . $rtl . ', "swipe": ' . $swipe . ', "draggable": ' . $draggable . ' }\'>';
			while ( $args->have_posts() ) :
				$args->the_post();
				$ids       = get_the_ID();
				$lcf_image = get_the_post_thumbnail_url( $ids, 'large' );

				$output .= '<div class="wpl-logo"><img src="' . $lcf_image . '" alt="' . get_the_title() . '" /></div>';
			endwhile;
			wp_reset_postdata();
			$output .= '</div>';
			$output .= '</div>';

			return $output;
		}

		/**
		 * Get post meta by id and key
		 *
		 * @param $post_id
		 * @param $key
		 * @param $default
		 *
		 * @return string|void
		 */
		public function get_meta( $post_id, $key, $default = null ) {
			$meta = get_post_meta( $post_id, $key, true );
			if ( empty( $meta ) && $default ) {
				$meta = $default;
			}

			if ( $meta == 'zero' ) {
				$meta = '0';
			}
			if ( $meta == 'on' ) {
				$meta = 'true';
			}
			if ( $meta == 'off' ) {
				$meta = 'false';
			}

			return esc_attr( $meta );
		}
	}

	new SPLC_Shortcode_Render();
}
