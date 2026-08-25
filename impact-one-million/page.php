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
						$iom_is_ambition     = function_exists( 'is_page' ) && (
							is_page( array( 'ambition', 'our-ambition' ) )
							|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Ambition' ) )
						);
						$iom_is_partners     = function_exists( 'is_page' ) && is_page( 'partners' );
						$iom_is_supply_chain = function_exists( 'is_page' ) && is_page( array( 'supply-chain', 'supply_chain' ) );
						$iom_is_gender_equality = function_exists( 'is_page' ) && (
							is_page(
								array(
									'gender-equality',
									'gender-and-equality',
									'gender',
								)
							)
							|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Gender Equality' ) )
						);
						$iom_is_respect_remedy = function_exists( 'is_page' ) && (
							is_page(
								array(
									'respect-and-remedy',
									'respect-remedy',
								)
							)
							|| (
								is_singular( 'page' )
								&& false !== stripos( (string) get_the_title(), 'Respect' )
								&& false !== stripos( (string) get_the_title(), 'Remedy' )
							)
						);
						$iom_is_healthcare = function_exists( 'is_page' ) && (
							is_page(
								array(
									'healthcare',
									'health-care',
									'health',
								)
							)
							|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Healthcare' ) )
							|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Health Care' ) )
						);
						$iom_is_financial_wellbeing = function_exists( 'is_page' ) && (
							is_page(
								array(
									'financial-wellbeing',
									'financial-well-being',
									'financial-wellbeing-development',
								)
							)
							|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Financial Wellbeing' ) )
							|| ( is_singular( 'page' ) && false !== stripos( (string) get_the_title(), 'Financial Well-being' ) )
						);
						$iom_is_education_skills = function_exists( 'is_page' ) && (
							is_page(
								array(
									'education-skills-and-development',
									'education-skills-development',
									'education-and-skills',
									'education',
								)
							)
							|| (
								is_singular( 'page' )
								&& false !== stripos( (string) get_the_title(), 'Education' )
								&& (
									false !== stripos( (string) get_the_title(), 'Skills' )
									|| false !== stripos( (string) get_the_title(), 'Development' )
								)
							)
						);

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
								(
									$iom_is_supply_chain
									&& 'other_pillars' === $layout
									&& 'join_reasons' === $iom_prev_layout
								)
								|| (
									( $iom_is_gender_equality || $iom_is_respect_remedy || $iom_is_healthcare || $iom_is_financial_wellbeing || $iom_is_education_skills )
									&& 'other_pillars' === $layout
									&& 'programme_in_action' === $iom_prev_layout
								)
							);

							// Pillar pages: Programme in Action → Pillars.
							$iom_tighten_programme_in_action_bottom = (
								( $iom_is_gender_equality || $iom_is_respect_remedy || $iom_is_healthcare || $iom_is_financial_wellbeing || $iom_is_education_skills )
								&& 'programme_in_action' === $layout
								&& 'other_pillars' === $iom_next_layout
							);

							// Ambition only: Why This Matters immediately followed by Our Ambition.
							$iom_tighten_why_this_matters_bottom = (
								$iom_is_ambition
								&& 'why_this_matters' === $layout
								&& 'our_ambition' === $iom_next_layout
							);
							$iom_tighten_our_ambition_top = (
								$iom_is_ambition
								&& 'our_ambition' === $layout
								&& 'why_this_matters' === $iom_prev_layout
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
