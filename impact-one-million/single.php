<?php
/**
 * Single Post — Case Study, Press Release, or News detail.
 *
 * Figma case study: 634:20702
 * Figma press release: 634:21026
 * Figma news article: 634:21152
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) {
		the_post();
		$post_id = get_the_ID();

		if ( has_category( 'press-release', $post_id ) ) {
			require locate_template( 'templates/press-release/content.php' );
		} elseif ( has_category( 'news', $post_id ) ) {
			require locate_template( 'templates/news/content.php' );
		} else {
			require locate_template( 'templates/case-study/content.php' );
		}
	}
	?>
</main>

<?php
get_footer();
