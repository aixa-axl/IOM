<?php
/**
 * Page Template with ACF Flexible Content
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php
					if ( function_exists( 'have_rows' ) && have_rows( 'page_sections' ) ) {
						// Count rows before the loop — get_field() after have_rows() can be unreliable.
						$page_sections_rows = get_field( 'page_sections' );
						$iom_sections_total = is_array( $page_sections_rows ) ? count( $page_sections_rows ) : 0;
						$iom_section_i      = 0;

						while ( have_rows( 'page_sections' ) ) {
							the_row();
							++$iom_section_i;

							$layout              = get_row_layout();
							$iom_is_last_section = ( $iom_section_i === $iom_sections_total );

							$layout_path = locate_template(
								array(
									'templates/layouts/' . $layout . '.php',
								)
							);

							if ( $layout_path ) {
								include $layout_path;
							}
						}
					} else {
						?>
						<div class="mx-auto max-w-[1440px] px-page py-12 lg:px-[60px]">
							<?php the_content(); ?>
						</div>
						<?php
					}
					?>
				</div>
			</article>
			<?php
		}
	}
	?>
</main>

<?php
get_footer();
