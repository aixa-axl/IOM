<?php
/**
 * Fallback Template
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="mx-auto max-w-[1440px] px-page py-12 xl:px-[60px]">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-8' ); ?>>
					<h2 class="mb-4 text-3xl font-bold">
						<a href="<?php the_permalink(); ?>" class="no-underline hover:opacity-80">
							<?php the_title(); ?>
						</a>
					</h2>
					<div class="prose max-w-none">
						<?php the_excerpt(); ?>
					</div>
				</article>
				<?php
			}
		} else {
			echo '<p>' . esc_html__( 'No posts found.', 'impact-one-million' ) . '</p>';
		}
		?>
	</div>
</main>

<?php
get_footer();
