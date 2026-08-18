<?php
/**
 * Press release single — field loader.
 *
 * Expects $post_id in scope.
 *
 * Figma: 634:21026
 *
 * @package Impact_One_Million
 */

if ( empty( $post_id ) ) {
	$post_id = get_the_ID();
}

$title = get_the_title( $post_id );
$date  = get_the_date( '', $post_id );

$breadcrumb_label = function_exists( 'get_field' ) ? get_field( 'pr_breadcrumb_label', $post_id ) : '';
$breadcrumb_title = function_exists( 'get_field' ) ? get_field( 'pr_breadcrumb_title', $post_id ) : '';
$display_title    = function_exists( 'get_field' ) ? get_field( 'pr_display_title', $post_id ) : '';
$intro            = function_exists( 'get_field' ) ? get_field( 'pr_intro', $post_id ) : '';
$overview         = function_exists( 'get_field' ) ? get_field( 'pr_overview', $post_id ) : '';
$meta_date        = function_exists( 'get_field' ) ? get_field( 'pr_meta_release_date', $post_id ) : '';
$meta_region      = function_exists( 'get_field' ) ? get_field( 'pr_meta_region', $post_id ) : '';
$meta_topic       = function_exists( 'get_field' ) ? get_field( 'pr_meta_topic', $post_id ) : '';
$meta_partner     = function_exists( 'get_field' ) ? get_field( 'pr_meta_partner', $post_id ) : '';
$body             = function_exists( 'get_field' ) ? get_field( 'pr_body', $post_id ) : '';
$gal_head         = function_exists( 'get_field' ) ? get_field( 'pr_gallery_heading', $post_id ) : '';
$gallery          = function_exists( 'get_field' ) ? get_field( 'pr_gallery', $post_id ) : array();
$quote            = function_exists( 'get_field' ) ? get_field( 'pr_quote', $post_id ) : '';
$quote_name       = function_exists( 'get_field' ) ? get_field( 'pr_quote_name', $post_id ) : '';
$quote_role       = function_exists( 'get_field' ) ? get_field( 'pr_quote_role', $post_id ) : '';
$rel_head         = function_exists( 'get_field' ) ? get_field( 'pr_related_heading', $post_id ) : '';
$rel_see_all      = function_exists( 'get_field' ) ? get_field( 'pr_related_see_all', $post_id ) : array();
$rel_link_label   = function_exists( 'get_field' ) ? get_field( 'pr_related_link_label', $post_id ) : '';
$related          = function_exists( 'get_field' ) ? get_field( 'pr_related', $post_id ) : array();
$partner_head     = function_exists( 'get_field' ) ? get_field( 'pr_partner_heading', $post_id ) : '';
$partner_intro    = function_exists( 'get_field' ) ? get_field( 'pr_partner_intro', $post_id ) : '';
$partner_cards    = function_exists( 'get_field' ) ? get_field( 'pr_partner_cards', $post_id ) : array();
$show_newsletter  = function_exists( 'get_field' ) ? get_field( 'pr_show_newsletter', $post_id ) : true;
$nl_heading       = function_exists( 'get_field' ) ? get_field( 'pr_newsletter_heading', $post_id ) : '';
$nl_body          = function_exists( 'get_field' ) ? get_field( 'pr_newsletter_body', $post_id ) : '';
$nl_placeholder   = function_exists( 'get_field' ) ? get_field( 'pr_newsletter_placeholder', $post_id ) : '';
$nl_button        = function_exists( 'get_field' ) ? get_field( 'pr_newsletter_button', $post_id ) : '';
$nl_privacy       = function_exists( 'get_field' ) ? get_field( 'pr_newsletter_privacy', $post_id ) : '';
$nl_action        = function_exists( 'get_field' ) ? get_field( 'pr_newsletter_action', $post_id ) : '';
$nl_image         = function_exists( 'get_field' ) ? get_field( 'pr_newsletter_image', $post_id ) : null;

if ( ! $gal_head ) {
	$gal_head = __( 'Gallery', 'impact-one-million' );
}
if ( ! $rel_head ) {
	$rel_head = __( 'Related Releases', 'impact-one-million' );
}
if ( ! $rel_link_label ) {
	$rel_link_label = __( 'Read press release', 'impact-one-million' );
}
if ( ! $partner_head ) {
	$partner_head = __( 'Help us reach further', 'impact-one-million' );
}
if ( ! $partner_intro ) {
	$partner_intro = __( 'Join our network of organizations committed to safer migration.', 'impact-one-million' );
}

if ( ! is_array( $gallery ) ) {
	$gallery = array();
}
if ( ! is_array( $related ) ) {
	$related = array();
}
if ( ! is_array( $rel_see_all ) ) {
	$rel_see_all = array();
}
if ( ! is_array( $partner_cards ) ) {
	$partner_cards = array();
}

$countries = get_the_terms( $post_id, 'country' );
if ( ! $meta_region && ! empty( $countries ) && ! is_wp_error( $countries ) ) {
	$meta_region = $countries[0]->name;
}
if ( ! $meta_topic && function_exists( 'iom_get_post_topic_label' ) ) {
	$meta_topic = iom_get_post_topic_label( $post_id );
}
if ( ! $meta_date && $date ) {
	$meta_date = $date;
}

if ( ! $breadcrumb_label ) {
	$breadcrumb_label = __( 'About Us', 'impact-one-million' );
}
if ( ! $breadcrumb_title ) {
	$breadcrumb_title = $title;
}
if ( ! $display_title ) {
	$display_title = $title;
}

$meta_rows = array(
	array( 'label' => __( 'Release Date', 'impact-one-million' ), 'value' => $meta_date ),
	array( 'label' => __( 'Region', 'impact-one-million' ), 'value' => $meta_region ),
	array( 'label' => __( 'Topic', 'impact-one-million' ), 'value' => $meta_topic ),
	array( 'label' => __( 'Partner', 'impact-one-million' ), 'value' => $meta_partner ),
);
$has_meta = false;
foreach ( $meta_rows as $row ) {
	if ( ! empty( $row['value'] ) ) {
		$has_meta = true;
		break;
	}
}

if ( empty( $related ) ) {
	$auto = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 3,
			'post__not_in'        => array( $post_id ),
			'ignore_sticky_posts' => true,
			'fields'              => 'ids',
			'category_name'       => 'press-release',
		)
	);
	$related = is_array( $auto ) ? $auto : array();
}

$link_label  = $rel_link_label;
$has_partner = ! empty( $partner_cards );

if ( null === $show_newsletter || '' === $show_newsletter ) {
	$show_newsletter = true;
}
$show_newsletter = (bool) $show_newsletter;
$email_id        = 'iom-pr-newsletter-email';

require locate_template( 'templates/parts/article-detail.php' );
