<?php
/**
 * Layout: why_this_matters
 *
 * Heading + intro, arrow stat cards (3+2 centered on desktop), footer body.
 * Desktop: wrapped / centered card rows.
 * Mobile: stacked — except Ambition page: horizontal snap scroll.
 *
 * Figma desktop: 634:20352 (no mobile frame — stacked adaptation)
 */

$heading = get_sub_field( 'heading' );
$intro   = get_sub_field( 'intro' );
$cards   = get_sub_field( 'cards' );
$footer  = get_sub_field( 'footer' );

$theme_uri = get_stylesheet_directory_uri();
$arrow_uri = $theme_uri . '/assets/images/icons/why-join-arrow.svg';

if ( ! is_array( $cards ) ) {
	$cards = array();
}

$iom_is_ambition_page = ! empty( $iom_is_ambition )
	|| ( function_exists( 'is_page' ) && is_page( array( 'ambition', 'our-ambition' ) ) );

// Ambition page only: less bottom padding on mobile when Our Ambition follows (set in page.php).
$section_class = ! empty( $iom_tighten_why_this_matters_bottom )
	? 'iom-why-this-matters bg-white px-page pt-10 pb-6 xl:px-section lg:py-gutter'
	: 'iom-why-this-matters bg-white px-page py-10 xl:px-section lg:py-gutter';

/**
 * Render one arrow stat card.
 *
 * @param string $label      Card label.
 * @param string $arrow_uri  Arrow icon URL.
 * @param string $li_class   Extra classes for the <li>.
 */
$iom_render_wtm_card = static function ( $label, $arrow_uri, $li_class = '' ) {
	$li_class = trim( 'flex flex-col items-start gap-4 rounded-card bg-off-white p-6 ' . $li_class );
	?>
	<li class="<?php echo esc_attr( $li_class ); ?>">
		<img
			src="<?php echo esc_url( $arrow_uri ); ?>"
			alt=""
			width="44"
			height="45"
			class="h-[2.8125rem] w-11 shrink-0"
			loading="lazy"
			decoding="async"
			aria-hidden="true"
		>
		<p class="m-0 font-display text-[2rem] uppercase leading-none tracking-[2px] text-blue">
			<?php echo esc_html( $label ); ?>
		</p>
	</li>
	<?php
};
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
		<?php if ( $heading || $intro ) : ?>
			<div class="flex w-full flex-col items-start gap-4">
				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $intro ) : ?>
					<?php echo iom_format_multiline_text( $intro, 'm-0 font-sans text-body leading-[1.2] text-muted' ); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) ) : ?>
			<?php
			$valid_cards = array();
			foreach ( $cards as $card ) {
				$label = isset( $card['label'] ) ? $card['label'] : '';
				if ( $label ) {
					$valid_cards[] = $label;
				}
			}

			$row_one = array_slice( $valid_cards, 0, 3 );
			$row_two = array_slice( $valid_cards, 3 );
			?>
			<?php if ( ! empty( $valid_cards ) ) : ?>
				<?php if ( $iom_is_ambition_page ) : ?>
					<?php // Ambition only: mobile horizontal snap scroll. ?>
					<ul class="m-0 -mx-page flex list-none gap-6 overflow-x-auto scroll-smooth px-page pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory lg:hidden [&::-webkit-scrollbar]:hidden">
						<?php foreach ( $valid_cards as $label ) : ?>
							<?php
							$iom_render_wtm_card(
								$label,
								$arrow_uri,
								'w-[min(85%,20rem)] shrink-0 snap-center'
							);
							?>
						<?php endforeach; ?>
					</ul>

					<?php // Ambition desktop: unchanged 3+2 grid. ?>
					<div class="hidden w-full flex-col gap-8 lg:flex">
						<?php if ( ! empty( $row_one ) ) : ?>
							<ul class="m-0 grid w-full list-none grid-cols-3 gap-8 p-0">
								<?php foreach ( $row_one as $label ) : ?>
									<?php $iom_render_wtm_card( $label, $arrow_uri ); ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( ! empty( $row_two ) ) : ?>
							<ul class="m-0 mx-auto grid w-[calc((200%-2rem)/3)] list-none grid-cols-2 gap-8 p-0">
								<?php foreach ( $row_two as $label ) : ?>
									<?php $iom_render_wtm_card( $label, $arrow_uri ); ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="flex w-full flex-col gap-8">
						<?php if ( ! empty( $row_one ) ) : ?>
							<ul class="m-0 grid w-full list-none grid-cols-1 gap-8 p-0 lg:grid-cols-3">
								<?php foreach ( $row_one as $label ) : ?>
									<?php $iom_render_wtm_card( $label, $arrow_uri ); ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( ! empty( $row_two ) ) : ?>
							<ul class="m-0 mx-auto grid w-full list-none grid-cols-1 gap-8 p-0 lg:w-[calc((200%-2rem)/3)] lg:grid-cols-2">
								<?php foreach ( $row_two as $label ) : ?>
									<?php $iom_render_wtm_card( $label, $arrow_uri ); ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( $footer ) : ?>
			<?php echo iom_format_multiline_text( $footer, 'm-0 max-w-[50rem] font-sans text-body leading-[1.2] text-muted' ); ?>
		<?php endif; ?>
	</div>
</section>
