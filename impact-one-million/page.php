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
						$iom_is_history      = function_exists( 'is_page' ) && is_page( 'history' );
						$iom_is_partners     = function_exists( 'is_page' ) && is_page( 'partners' );
						$iom_is_supply_chain = function_exists( 'is_page' ) && is_page( array( 'supply-chain', 'supply_chain' ) );

						while ( have_rows( 'page_sections' ) ) {
							the_row();
							++$iom_section_i;

							$layout              = get_row_layout();
							$iom_is_last_section = ( $iom_section_i === $iom_sections_total );

							// Adjacent layout names (0-based indices around the current 1-based row).
							$iom_prev_layout = '';
							$iom_next_layout = '';
							if ( is_array( $page_sections_rows ) ) {
								if ( $iom_section_i > 1 && isset( $page_sections_rows[ $iom_section_i - 2 ]['acf_fc_layout'] ) ) {
									$iom_prev_layout = (string) $page_sections_rows[ $iom_section_i - 2 ]['acf_fc_layout'];
								}
								if ( isset( $page_sections_rows[ $iom_section_i ]['acf_fc_layout'] ) ) {
									$iom_next_layout = (string) $page_sections_rows[ $iom_section_i ]['acf_fc_layout'];
								}
							}

							// History only: Evolution immediately followed by Looking Ahead.
							$iom_tighten_evolution_bottom  = (
								$iom_is_history
								&& 'the_evolution' === $layout
								&& 'looking_ahead' === $iom_next_layout
							);
							$iom_tighten_looking_ahead_top = (
								$iom_is_history
								&& 'looking_ahead' === $layout
								&& 'the_evolution' === $iom_prev_layout
							);

							// Partners only: Stories of Change immediately followed by How It Works.
							$iom_tighten_stories_of_change_bottom = (
								$iom_is_partners
								&& 'stories_of_change' === $layout
								&& 'process_steps' === $iom_next_layout
							);
							$iom_tighten_process_steps_top = (
								$iom_is_partners
								&& 'process_steps' === $layout
								&& 'stories_of_change' === $iom_prev_layout
							);

							// Supply chain only: Join Reasons immediately followed by Pillars.
							$iom_tighten_join_reasons_bottom = (
								$iom_is_supply_chain
								&& 'join_reasons' === $layout
								&& 'other_pillars' === $iom_next_layout
							);
							$iom_tighten_other_pillars_top = (
								$iom_is_supply_chain
								&& 'other_pillars' === $layout
								&& 'join_reasons' === $iom_prev_layout
							);

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
						<div class="mx-auto max-w-[1440px] px-page py-12 xl:px-[60px]">
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
