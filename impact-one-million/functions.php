<?php
/**
 * Impact One Million Theme Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Setup
 */
function iom_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'impact-one-million' ),
			'footer'  => __( 'Footer Menu', 'impact-one-million' ),
		)
	);

	load_theme_textdomain( 'impact-one-million', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'iom_theme_setup' );

/**
 * Country taxonomy for posts (news / case studies location tags).
 */
function iom_register_taxonomies() {
	register_taxonomy(
		'country',
		array( 'post' ),
		array(
			'labels'            => array(
				'name'          => __( 'Countries', 'impact-one-million' ),
				'singular_name' => __( 'Country', 'impact-one-million' ),
				'search_items'  => __( 'Search Countries', 'impact-one-million' ),
				'all_items'     => __( 'All Countries', 'impact-one-million' ),
				'edit_item'     => __( 'Edit Country', 'impact-one-million' ),
				'update_item'   => __( 'Update Country', 'impact-one-million' ),
				'add_new_item'  => __( 'Add New Country', 'impact-one-million' ),
				'new_item_name' => __( 'New Country Name', 'impact-one-million' ),
				'menu_name'     => __( 'Countries', 'impact-one-million' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'country' ),
		)
	);
}
add_action( 'init', 'iom_register_taxonomies' );

/**
 * Enqueue Styles and Scripts
 */
function iom_enqueue_assets() {
	$compiled_css_rel_path = '/assets/css/style.css';
	$compiled_css_abs_path = get_stylesheet_directory() . $compiled_css_rel_path;
	$compiled_css_uri      = get_stylesheet_directory_uri() . $compiled_css_rel_path;
	$main_js_rel_path      = '/assets/js/main.js';
	$main_js_abs_path      = get_stylesheet_directory() . $main_js_rel_path;
	$main_js_uri           = get_stylesheet_directory_uri() . $main_js_rel_path;
	$theme_version         = wp_get_theme()->get( 'Version' );
	$css_version           = file_exists( $compiled_css_abs_path ) ? filemtime( $compiled_css_abs_path ) : $theme_version;
	$js_version            = file_exists( $main_js_abs_path ) ? filemtime( $main_js_abs_path ) : $theme_version;

	wp_enqueue_style(
		'iom-style',
		$compiled_css_uri,
		array(),
		$css_version
	);

	wp_enqueue_script(
		'iom-main',
		$main_js_uri,
		array(),
		$js_version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'iom_enqueue_assets' );

/**
 * ACF JSON save/load paths — field groups live in the repo.
 */
add_filter(
	'acf/settings/save_json',
	function () {
		return get_stylesheet_directory() . '/acf-json';
	}
);

add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = get_stylesheet_directory() . '/acf-json';
		return $paths;
	}
);

/**
 * Site-wide Theme Settings (header / footer) — not page Flexible Content.
 */
function iom_register_acf_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Theme Settings', 'impact-one-million' ),
			'menu_title' => __( 'Theme Settings', 'impact-one-million' ),
			'menu_slug'  => 'iom-theme-settings',
			'capability' => 'edit_theme_options',
			'redirect'   => false,
			'position'   => 61,
			'icon_url'   => 'dashicons-admin-customizer',
		)
	);
}
add_action( 'acf/init', 'iom_register_acf_options_page' );

/**
 * Render an ACF link array as an <a>, or nothing if URL is empty.
 *
 * @param array|false $link    ACF link field value.
 * @param string      $class   CSS classes.
 * @param string      $fallback_title Optional title when link title is empty.
 */
function iom_render_link( $link, $class = '', $fallback_title = '' ) {
	if ( empty( $link['url'] ) ) {
		return;
	}

	$title  = ! empty( $link['title'] ) ? $link['title'] : $fallback_title;
	$target = ! empty( $link['target'] ) ? $link['target'] : '';
	$rel    = '_blank' === $target ? 'noopener noreferrer' : '';
	?>
	<a
		href="<?php echo esc_url( $link['url'] ); ?>"
		class="<?php echo esc_attr( $class ); ?>"
		<?php echo $target ? 'target="' . esc_attr( $target ) . '"' : ''; ?>
		<?php echo $rel ? 'rel="' . esc_attr( $rel ) . '"' : ''; ?>
	>
		<?php echo esc_html( $title ); ?>
	</a>
	<?php
}

/**
 * Light hardening
 */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'xmlrpc_enabled', '__return_false' );
