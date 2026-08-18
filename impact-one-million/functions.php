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
 * Content-type category slugs (Case Study / News / Press Release).
 *
 * @return string[]
 */
function iom_content_type_slugs() {
	return array( 'case-study', 'news', 'press-release' );
}

/**
 * Ensure the three content-type categories exist.
 */
function iom_seed_content_type_categories() {
	$types = array(
		'case-study'    => __( 'Case Study', 'impact-one-million' ),
		'news'          => __( 'News', 'impact-one-million' ),
		'press-release' => __( 'Press Release', 'impact-one-million' ),
	);

	foreach ( $types as $slug => $name ) {
		if ( ! term_exists( $slug, 'category' ) ) {
			wp_insert_term(
				$name,
				'category',
				array(
					'slug' => $slug,
				)
			);
		}
	}
}
add_action( 'init', 'iom_seed_content_type_categories', 20 );

/**
 * Relabel post tags as Topics in wp-admin.
 *
 * @param object $labels Taxonomy labels.
 * @return object
 */
function iom_relabel_tags_as_topics( $labels ) {
	$labels->name                       = __( 'Topics', 'impact-one-million' );
	$labels->singular_name              = __( 'Topic', 'impact-one-million' );
	$labels->search_items               = __( 'Search Topics', 'impact-one-million' );
	$labels->popular_items              = __( 'Popular Topics', 'impact-one-million' );
	$labels->all_items                  = __( 'All Topics', 'impact-one-million' );
	$labels->edit_item                  = __( 'Edit Topic', 'impact-one-million' );
	$labels->view_item                  = __( 'View Topic', 'impact-one-million' );
	$labels->update_item                = __( 'Update Topic', 'impact-one-million' );
	$labels->add_new_item               = __( 'Add New Topic', 'impact-one-million' );
	$labels->new_item_name              = __( 'New Topic Name', 'impact-one-million' );
	$labels->separate_items_with_commas = __( 'Separate topics with commas', 'impact-one-million' );
	$labels->add_or_remove_items        = __( 'Add or remove topics', 'impact-one-million' );
	$labels->choose_from_most_used      = __( 'Choose from the most used topics', 'impact-one-million' );
	$labels->not_found                  = __( 'No topics found.', 'impact-one-million' );
	$labels->menu_name                  = __( 'Topics', 'impact-one-million' );
	$labels->back_to_items              = __( '← Go to Topics', 'impact-one-million' );
	$labels->name_admin_bar             = __( 'Topic', 'impact-one-million' );
	$labels->archives                   = __( 'Topics', 'impact-one-million' );

	return $labels;
}
add_filter( 'taxonomy_labels_post_tag', 'iom_relabel_tags_as_topics' );

/**
 * Primary topic label for a post (first post_tag).
 * Falls back to first non-type category during migration.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function iom_get_post_topic_label( $post_id ) {
	$topics = get_the_terms( $post_id, 'post_tag' );
	if ( ! empty( $topics ) && ! is_wp_error( $topics ) ) {
		return $topics[0]->name;
	}

	$categories = get_the_category( $post_id );
	$type_slugs = iom_content_type_slugs();
	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $cat ) {
			if ( in_array( $cat->slug, $type_slugs, true ) || 'uncategorized' === $cat->slug ) {
				continue;
			}
			return $cat->name;
		}
	}

	return '';
}

/**
 * Topic terms for hero pills (excludes content-type categories).
 *
 * @param int $post_id Post ID.
 * @return string[]
 */
function iom_get_post_topic_labels( $post_id ) {
	$labels     = array();
	$type_slugs = iom_content_type_slugs();

	$topics = get_the_terms( $post_id, 'post_tag' );
	if ( ! empty( $topics ) && ! is_wp_error( $topics ) ) {
		foreach ( $topics as $term ) {
			$labels[] = $term->name;
		}
	}

	// Migration fallback: old topic-like categories.
	$categories = get_the_category( $post_id );
	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $cat ) {
			if ( in_array( $cat->slug, $type_slugs, true ) || 'uncategorized' === $cat->slug ) {
				continue;
			}
			$labels[] = $cat->name;
		}
	}

	return array_values( array_unique( array_filter( $labels ) ) );
}

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

	wp_localize_script(
		'iom-main',
		'iomData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'iom_case_studies' ),
		)
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
 * Mailchimp (or other) newsletter form action URL from Theme Settings.
 *
 * @return string
 */
function iom_get_newsletter_form_action() {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$url = get_field( 'newsletter_form_action', 'option' );
	return is_string( $url ) ? trim( $url ) : '';
}

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
 * Build a WP_Query for the case studies filter/grid.
 *
 * @param array $args Filters: category, year, region, topic, search, paged, posts_per_page.
 * @return WP_Query
 */
function iom_case_studies_query( $args = array() ) {
	$defaults = array(
		'category'       => '',
		'year'           => '',
		'region'         => '',
		'topic'          => '',
		'search'         => '',
		'paged'          => 1,
		'posts_per_page' => 6,
	);
	$args     = wp_parse_args( $args, $defaults );

	$query_args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'paged'               => max( 1, (int) $args['paged'] ),
		'posts_per_page'      => max( 1, (int) $args['posts_per_page'] ),
	);

	if ( ! empty( $args['search'] ) ) {
		$query_args['s'] = sanitize_text_field( $args['search'] );
	}

	if ( ! empty( $args['year'] ) ) {
		$query_args['date_query'] = array(
			array(
				'year' => (int) $args['year'],
			),
		);
	}

	$tax_query = array();

	if ( ! empty( $args['category'] ) ) {
		$tax_query[] = array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => sanitize_title( $args['category'] ),
		);
	}

	if ( ! empty( $args['region'] ) ) {
		$tax_query[] = array(
			'taxonomy' => 'country',
			'field'    => 'slug',
			'terms'    => sanitize_title( $args['region'] ),
		);
	}

	if ( ! empty( $args['topic'] ) ) {
		$tax_query[] = array(
			'taxonomy' => 'post_tag',
			'field'    => 'slug',
			'terms'    => sanitize_title( $args['topic'] ),
		);
	}

	if ( count( $tax_query ) > 1 ) {
		$tax_query['relation'] = 'AND';
	}

	if ( ! empty( $tax_query ) ) {
		$query_args['tax_query'] = $tax_query;
	}

	return new WP_Query( $query_args );
}

/**
 * AJAX: filter / load more case studies.
 */
function iom_ajax_case_studies() {
	check_ajax_referer( 'iom_case_studies', 'nonce' );

	$paged          = isset( $_POST['paged'] ) ? (int) $_POST['paged'] : 1;
	$posts_per_page = isset( $_POST['posts_per_page'] ) ? (int) $_POST['posts_per_page'] : 6;
	$link_label     = isset( $_POST['link_label'] ) ? sanitize_text_field( wp_unslash( $_POST['link_label'] ) ) : '';
	$append         = ! empty( $_POST['append'] );

	$allowed_types = iom_content_type_slugs();
	$content_type  = isset( $_POST['content_type'] ) ? sanitize_title( wp_unslash( $_POST['content_type'] ) ) : '';
	if ( ! in_array( $content_type, $allowed_types, true ) ) {
		$content_type = 'case-study';
	}

	if ( ! $link_label ) {
		$link_label = __( 'Read case study', 'impact-one-million' );
	}

	$query = iom_case_studies_query(
		array(
			'category'       => $content_type,
			'year'           => isset( $_POST['year'] ) ? sanitize_text_field( wp_unslash( $_POST['year'] ) ) : '',
			'region'         => isset( $_POST['region'] ) ? sanitize_text_field( wp_unslash( $_POST['region'] ) ) : '',
			'topic'          => isset( $_POST['topic'] ) ? sanitize_text_field( wp_unslash( $_POST['topic'] ) ) : '',
			'search'         => isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '',
			'paged'          => $paged,
			'posts_per_page' => $posts_per_page,
		)
	);

	ob_start();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id = get_the_ID();
			require locate_template( 'templates/parts/case-study-card.php' );
		}
		wp_reset_postdata();
	}
	$html = ob_get_clean();

	wp_send_json_success(
		array(
			'html'      => $html,
			'append'    => $append,
			'page'      => $paged,
			'maxPages'  => (int) $query->max_num_pages,
			'found'     => (int) $query->found_posts,
			'hasMore'   => $paged < (int) $query->max_num_pages,
		)
	);
}
add_action( 'wp_ajax_iom_case_studies', 'iom_ajax_case_studies' );
add_action( 'wp_ajax_nopriv_iom_case_studies', 'iom_ajax_case_studies' );

/**
 * Light hardening
 */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'xmlrpc_enabled', '__return_false' );
