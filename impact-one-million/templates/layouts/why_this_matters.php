<?php
/**
 * Layout: why_this_matters
 *
 * Heading + intro, arrow stat cards (3+2 centered on desktop), footer body.
 * Desktop: wrapped / centered card rows. Mobile: horizontal snap scroll + dots.
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

// Ambition page only: less bottom padding on mobile when Our Ambition follows (set in page.php).
$section_class = ! empty( $iom_tighten_why_this_matters_bottom )
	? 'iom-why-this-matters overflow-x-hidden bg-white px-0 pt-10 pb-6 xl:px-section lg:py-gutter'
	: 'iom-why-this-matters overflow-x-hidden bg-white px-0 py-10 xl:px-section lg:py-gutter';

/**
 * Render one arrow stat card.
 *
 * @param string $label     Card label.
 * @param string $arrow_uri Arrow icon URL.
 * @param bool   $carousel  Mobile carousel slide.
 */
$iom_render_wtm_card = static function ( $label, $arrow_uri, $carousel = false ) {
	$li_class = $carousel
		? 'flex w-[min(100%,20rem)] shrink-0 snap-center flex-col items-start gap-4 rounded-card bg-off-white p-6'
		: 'flex flex-col items-start gap-4 rounded-card bg-off-white p-6';
	?>
	<li
		class="<?php echo esc_attr( $li_class ); ?>"
		<?php echo $carousel ? 'data-why-this-matters-slide' : ''; ?>
	>
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
		<p class="m-0 font-display text-[1.5rem] uppercase leading-none tracking-[2px] text-blue lg:text-[2rem]">
			<?php echo esc_html( $label ); ?>
		</p>
	</li>
	<?php
};
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-10">
		<?php if ( $heading || $intro ) : ?>
			<div class="flex w-full flex-col items-start gap-4 px-page xl:px-0">
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

			$card_count = count( $valid_cards );
			$row_one    = array_slice( $valid_cards, 0, 3 );
			$row_two    = array_slice( $valid_cards, 3 );
			?>
			<?php if ( ! empty( $valid_cards ) ) : ?>
				<div class="w-full lg:hidden" data-why-this-matters-carousel>
					<ul
						class="m-0 flex list-none gap-6 overflow-x-auto scroll-smooth px-page pb-2 [-ms-overflow-style:none] [scrollbar-width:none] snap-x snap-mandatory [&::-webkit-scrollbar]:hidden"
						data-why-this-matters-track
					>
						<?php foreach ( $valid_cards as $label ) : ?>
							<?php $iom_render_wtm_card( $label, $arrow_uri, true ); ?>
						<?php endforeach; ?>
					</ul>

					<?php if ( $card_count > 1 ) : ?>
						<div class="mt-6 flex items-center justify-center gap-2" data-why-this-matters-dots aria-hidden="true">
							<?php for ( $i = 0; $i < $card_count; $i++ ) : ?>
								<span
									class="size-1.5 rounded-full bg-accent-blue/25 transition-colors data-[active=true]:bg-accent-blue"
									data-why-this-matters-dot
									<?php echo 0 === $i ? 'data-active="true"' : ''; ?>
								></span>
							<?php endfor; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="hidden w-full flex-col gap-8 px-page lg:flex xl:px-0">
					<?php if ( ! empty( $row_one ) ) : ?>
						<ul class="m-0 grid w-full list-none grid-cols-3 gap-8 p-0">
							<?php foreach ( $row_one as $label ) : ?>
								<?php $iom_render_wtm_card( $label, $arrow_uri, false ); ?>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( ! empty( $row_two ) ) : ?>
						<ul class="m-0 mx-auto grid w-[calc((200%-2rem)/3)] list-none grid-cols-2 gap-8 p-0">
							<?php foreach ( $row_two as $label ) : ?>
								<?php $iom_render_wtm_card( $label, $arrow_uri, false ); ?>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( $footer ) : ?>
			<div class="w-full px-page xl:px-0">
				<?php echo iom_format_multiline_text( $footer, 'm-0 max-w-[50rem] font-sans text-body leading-[1.2] text-muted' ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
