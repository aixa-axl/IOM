<?php
/**
 * Search Results Template
 */

get_header();

$iom_query = get_search_query();
?>

<main id="primary" class="site-main">
	<div class="mx-auto max-w-site px-page py-12 lg:px-gutter lg:py-16">
		<header class="mb-10">
			<h1 class="font-display text-headline uppercase tracking-wide text-navy">
				<?php
				if ( $iom_query ) {
					printf(
						/* translators: %s: search query */
						esc_html__( 'Search results for “%s”', 'impact-one-million' ),
						esc_html( $iom_query )
					);
				} else {
					esc_html_e( 'Search', 'impact-one-million' );
				}
				?>
			</h1>
			<div class="mt-6 max-w-2xl">
				<?php get_search_form(); ?>
			</div>
		</header>

		<?php if ( have_posts() ) : ?>
			<ul class="m-0 flex list-none flex-col gap-8 p-0">
				<?php
				while ( have_posts() ) {
					the_post();
					?>
					<li>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<h2 class="font-display text-card-title uppercase tracking-[1px] text-navy">
								<a href="<?php the_permalink(); ?>" class="no-underline transition-opacity hover:opacity-70">
									<?php the_title(); ?>
								</a>
							</h2>
							<?php if ( has_excerpt() || get_the_content() ) : ?>
								<div class="mt-2 font-sans text-body text-muted">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>
						</article>
					</li>
					<?php
				}
				?>
			</ul>

			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 1,
					'prev_text' => __( 'Previous', 'impact-one-million' ),
					'next_text' => __( 'Next', 'impact-one-million' ),
					'class'     => 'mt-12',
				)
			);
			?>
		<?php else : ?>
			<p class="font-sans text-body text-muted">
				<?php esc_html_e( 'No results found. Try a different search.', 'impact-one-million' ); ?>
			</p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
