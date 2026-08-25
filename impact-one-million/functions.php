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

	// Hero background — avoid serving original uploads (often 3000–5000px).
	add_image_size( 'iom-hero', 1920, 1440, false );
	add_image_size( 'iom-hero-sm', 800, 600, false );

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
 * Topic slugs that only appear in the News content filter grid.
 *
 * @return string[]
 */
function iom_news_only_topic_slugs() {
	return array( 'events' );
}

/**
 * Topics (post tags) for the content filter dropdown, scoped to a content type.
 * News-only topics (e.g. Events) are excluded from Case Study / Press Release grids.
 *
 * @param string $content_type Category slug: case-study | news | press-release.
 * @return WP_Term[]
 */
function iom_get_filter_topics_for_content_type( $content_type ) {
	$content_type = sanitize_title( $content_type );
	$allowed      = iom_content_type_slugs();
	if ( ! in_array( $content_type, $allowed, true ) ) {
		$content_type = 'case-study';
	}

	global $wpdb;

	$term_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT DISTINCT t.term_id
			FROM {$wpdb->terms} AS t
			INNER JOIN {$wpdb->term_taxonomy} AS tt
				ON t.term_id = tt.term_id AND tt.taxonomy = 'post_tag'
			INNER JOIN {$wpdb->term_relationships} AS tr
				ON tt.term_taxonomy_id = tr.term_taxonomy_id
			INNER JOIN {$wpdb->posts} AS p
				ON p.ID = tr.object_id AND p.post_type = 'post' AND p.post_status = 'publish'
			INNER JOIN {$wpdb->term_relationships} AS tr_cat
				ON p.ID = tr_cat.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS tt_cat
				ON tr_cat.term_taxonomy_id = tt_cat.term_taxonomy_id AND tt_cat.taxonomy = 'category'
			INNER JOIN {$wpdb->terms} AS t_cat
				ON tt_cat.term_id = t_cat.term_id AND t_cat.slug = %s
			ORDER BY t.name ASC",
			$content_type
		)
	);

	$topics = array();

	if ( ! empty( $term_ids ) ) {
		$found = get_terms(
			array(
				'taxonomy'   => 'post_tag',
				'include'    => array_map( 'intval', $term_ids ),
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
			)
		);
		if ( ! empty( $found ) && ! is_wp_error( $found ) ) {
			$topics = $found;
		}
	}

	if ( 'news' !== $content_type ) {
		$news_only = iom_news_only_topic_slugs();
		$topics    = array_values(
			array_filter(
				$topics,
				static function ( $term ) use ( $news_only ) {
					return ! in_array( $term->slug, $news_only, true );
				}
			)
		);
	} else {
		// Always offer news-only topics (e.g. Events) even before posts are tagged.
		$existing_slugs = wp_list_pluck( $topics, 'slug' );
		foreach ( iom_news_only_topic_slugs() as $slug ) {
			if ( in_array( $slug, $existing_slugs, true ) ) {
				continue;
			}
			$term = get_term_by( 'slug', $slug, 'post_tag' );
			if ( $term && ! is_wp_error( $term ) ) {
				$topics[] = $term;
			}
		}
		usort(
			$topics,
			static function ( $a, $b ) {
				return strcasecmp( $a->name, $b->name );
			}
		);
	}

	return $topics;
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
	$type_slugs = array_merge( iom_content_type_slugs(), array( 'uncategorized', 'events' ) );
	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $cat ) {
			if ( in_array( $cat->slug, $type_slugs, true ) ) {
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
	$type_slugs = array_merge( iom_content_type_slugs(), array( 'uncategorized', 'events' ) );

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
 * Prefer compressed JPEGs for derivatives (hero uploads stay lighter).
 *
 * @param int $quality Default quality.
 * @return int
 */
function iom_jpeg_quality( $quality ) {
	return 80;
}
add_filter( 'jpeg_quality', 'iom_jpeg_quality' );
add_filter( 'wp_editor_set_quality', 'iom_jpeg_quality' );

/**
 * Whether the current page’s first section is an above-the-fold hero with a photo.
 *
 * @return bool
 */
function iom_page_has_lcp_hero() {
	if ( is_admin() || ! function_exists( 'get_field' ) || ! is_page() ) {
		return false;
	}

	$sections = get_field( 'page_sections' );
	if ( empty( $sections[0] ) || ! is_array( $sections[0] ) ) {
		return false;
	}

	$row = $sections[0];
	if ( empty( $row['acf_fc_layout'] ) || 'hero' !== $row['acf_fc_layout'] ) {
		return false;
	}

	if ( ! empty( $row['background_color'] ) && 'accent_blue' === $row['background_color'] ) {
		return false;
	}

	return ! empty( $row['background_image'] );
}

/**
 * Build hero background <img> HTML using only intermediate sizes (never the full original).
 * Caps candidates at 1920w so phones/desktops do not download 4–6MB uploads.
 *
 * @param int   $attachment_id Attachment ID.
 * @param array $attrs         Img attributes.
 * @return string
 */
function iom_get_hero_background_image( $attachment_id, $attrs = array() ) {
	$attachment_id = (int) $attachment_id;
	if ( ! $attachment_id ) {
		return '';
	}

	$size_keys = array( 'iom-hero-sm', 'medium_large', 'large', 'iom-hero' );
	$by_width  = array();

	foreach ( $size_keys as $size ) {
		$img = wp_get_attachment_image_src( $attachment_id, $size );
		if ( empty( $img[0] ) || empty( $img[1] ) ) {
			continue;
		}
		$width = (int) $img[1];
		// Skip accidental full-size fallbacks over the hero cap.
		if ( $width > 1920 ) {
			continue;
		}
		$by_width[ $width ] = $img;
	}

	// Last resort: large/full but still refuse absurd originals when a smaller exists.
	if ( empty( $by_width ) ) {
		foreach ( array( 'large', 'medium_large', 'medium' ) as $size ) {
			$img = wp_get_attachment_image_src( $attachment_id, $size );
			if ( ! empty( $img[0] ) ) {
				$by_width[ (int) $img[1] ] = $img;
				break;
			}
		}
	}

	if ( empty( $by_width ) ) {
		return '';
	}

	ksort( $by_width, SORT_NUMERIC );
	$default = end( $by_width );

	$srcset_parts = array();
	foreach ( $by_width as $width => $img ) {
		$srcset_parts[] = esc_url( $img[0] ) . ' ' . $width . 'w';
	}

	$sizes = isset( $attrs['sizes'] ) ? $attrs['sizes'] : '(max-width: 1023px) 100vw, min(1080px, 75vw)';
	unset( $attrs['sizes'] );

	$attrs = wp_parse_args(
		$attrs,
		array(
			'src'     => $default[0],
			'width'   => (int) $default[1],
			'height'  => (int) $default[2],
			'alt'     => '',
			'class'   => '',
			'srcset'  => implode( ', ', $srcset_parts ),
			'sizes'   => $sizes,
			'decoding'=> 'async',
		)
	);

	$html = '<img';
	foreach ( $attrs as $name => $value ) {
		if ( '' === $value && 'alt' !== $name ) {
			continue;
		}
		$html .= ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
	}
	$html .= ' />';

	return $html;
}

/**
 * Preload above-the-fold hero background (LCP) when it is the first page section.
 */
function iom_preload_hero_lcp() {
	if ( ! iom_page_has_lcp_hero() ) {
		return;
	}

	$sections = get_field( 'page_sections' );
	$image_id = ! empty( $sections[0]['background_image'] ) ? (int) $sections[0]['background_image'] : 0;
	if ( ! $image_id ) {
		return;
	}

	// Mirror the same capped candidates as the visible <img>.
	$size_keys = array( 'iom-hero-sm', 'medium_large', 'large', 'iom-hero' );
	$by_width  = array();
	foreach ( $size_keys as $size ) {
		$img = wp_get_attachment_image_src( $image_id, $size );
		if ( empty( $img[0] ) || empty( $img[1] ) || (int) $img[1] > 1920 ) {
			continue;
		}
		$by_width[ (int) $img[1] ] = $img;
	}
	if ( empty( $by_width ) ) {
		return;
	}

	ksort( $by_width, SORT_NUMERIC );
	$default = end( $by_width );
	$sizes   = '(max-width: 1023px) 100vw, min(1080px, 75vw)';
	$srcset  = array();
	foreach ( $by_width as $width => $img ) {
		$srcset[] = $img[0] . ' ' . $width . 'w';
	}

	echo '<link rel="preload" as="image" href="' . esc_url( $default[0] ) . '" fetchpriority="high"';
	echo ' imagesrcset="' . esc_attr( implode( ', ', $srcset ) ) . '"';
	echo ' imagesizes="' . esc_attr( $sizes ) . '"';
	echo ">\n";
}
add_action( 'wp_head', 'iom_preload_hero_lcp', 2 );

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
 * Format plain multiline text as paragraphs (Enter in a textarea = new paragraph).
 *
 * @param string $text    Raw textarea value.
 * @param string $p_class CSS classes applied to each paragraph.
 * @return string Safe HTML (empty string when no content).
 */
function iom_format_multiline_text( $text, $p_class = 'm-0' ) {
	$text = is_string( $text ) ? $text : '';
	if ( '' === trim( $text ) ) {
		return '';
	}

	$lines = preg_split( '/\r\n|\r|\n/', $text );
	if ( ! is_array( $lines ) ) {
		return '';
	}

	$parts = array();
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$parts[] = $line;
		}
	}

	if ( empty( $parts ) ) {
		return '';
	}

	$html = '';
	foreach ( $parts as $i => $line ) {
		$class = trim( $p_class . ( $i > 0 ? ' mt-3' : '' ) );
		$html .= '<p class="' . esc_attr( $class ) . '">' . esc_html( $line ) . '</p>';
	}

	return $html;
}

/**
 * Build an inline-playable video embed from ACF source fields.
 *
 * @param string          $video_source external|upload.
 * @param string|null     $video_url    External URL (YouTube / Vimeo / file).
 * @param int|string|null $video_file   Attachment ID for Media Library upload.
 * @return array{type:string,src:string}|null
 */
function iom_build_video_embed( $video_source = 'external', $video_url = '', $video_file = 0 ) {
	if ( ! $video_source ) {
		$video_source = 'external';
	}

	if ( 'upload' === $video_source && $video_file ) {
		$file_url = wp_get_attachment_url( (int) $video_file );
		if ( $file_url ) {
			return array(
				'type' => 'video',
				'src'  => $file_url,
			);
		}
		return null;
	}

	$video_url = is_string( $video_url ) ? trim( $video_url ) : '';
	if ( ! $video_url ) {
		return null;
	}

	if ( preg_match( '#(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{6,})#', $video_url, $m ) ) {
		return array(
			'type' => 'iframe',
			'src'  => 'https://www.youtube.com/embed/' . rawurlencode( $m[1] ) . '?autoplay=1&rel=0',
		);
	}

	if ( preg_match( '#vimeo\.com/(?:video/)?(\d+)#', $video_url, $m ) ) {
		return array(
			'type' => 'iframe',
			'src'  => 'https://player.vimeo.com/video/' . rawurlencode( $m[1] ) . '?autoplay=1',
		);
	}

	if ( preg_match( '#\.(mp4|webm|ogg|m4v)(\?|$)#i', $video_url ) ) {
		return array(
			'type' => 'video',
			'src'  => $video_url,
		);
	}

	return array(
		'type' => 'iframe',
		'src'  => $video_url,
	);
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
		$topic_slug = sanitize_title( $args['topic'] );
		// Events (and other news-only topics) only apply on the News grid.
		if (
			in_array( $topic_slug, iom_news_only_topic_slugs(), true )
			&& 'news' !== sanitize_title( $args['category'] )
		) {
			$topic_slug = '';
		}
		if ( $topic_slug ) {
			$tax_query[] = array(
				'taxonomy' => 'post_tag',
				'field'    => 'slug',
				'terms'    => $topic_slug,
			);
		}
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
