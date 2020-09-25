<?php
/**
 * This file add meta box to logo post
 *
 * @package logo-carousel-free
 */

$this->metaboxform->url_disabled(
	array(
		'id'    => 'wpl_lcp_logo_link_option',
		'name'  => __( 'Custom URL', 'logo-carousel-free' ),
		'desc'  => __( 'Type logo link url.', 'logo-carousel-free' ),
		'after' => __( '', 'logo-carousel-free' ),
		'std'   => '#',
	)
);
