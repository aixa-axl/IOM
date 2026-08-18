<?php
/**
 * Single Post — Case Study detail template.
 *
 * Figma: 634:20702 (case-study-detail-page)
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) {
		the_post();
		$post_id = get_the_ID();
		require locate_template( 'templates/case-study/content.php' );
	}
	?>
</main>

<?php
get_footer();
