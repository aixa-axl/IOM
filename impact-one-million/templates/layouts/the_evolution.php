<?php
/**
 * Layout: the_evolution
 *
 * Eyebrow + heading + optional intro, then cards with title + point lists.
 * Desktop: 3 columns (3+3 when 6 cards). Mobile: stacked.
 * With 3 or fewer cards, middle card is slightly larger (Figma hierarchy).
 *
 * Figma desktop: 634:20018 (no mobile frame — stacked adaptation)
 */

$eyebrow = get_sub_field( 'eyebrow' );
$heading = get_sub_field( 'heading' );
$intro   = get_sub_field( 'intro' );
$cards   = get_sub_field( 'cards' );

if ( ! $eyebrow ) {
	$eyebrow = __( 'The Evolution', 'impact-one-million' );
}

if ( ! $heading ) {
	$heading = __( 'Growth through learning', 'impact-one-million' );
}

if ( ! is_array( $cards ) ) {
	$cards = array();
}

$card_count = count( $cards );
$use_grid   = ( $card_count > 3 );

// History page only: less bottom padding when Looking Ahead follows (set in page.php).
$section_class = ! empty( $iom_tighten_evolution_bottom )
	? 'iom-the-evolution bg-white px-page py-10 lg:pt-[100px] lg:pb-8 xl:px-[6.25rem]'
	: 'iom-the-evolution bg-white px-page py-10 lg:py-[100px] xl:px-[6.25rem]';

$list_class = $use_grid
	? 'm-0 grid w-full list-none grid-cols-1 items-stretch gap-8 p-0 lg:grid-cols-3'
	: 'm-0 flex w-full list-none flex-col items-stretch gap-8 p-0 lg:flex-row lg:items-center lg:gap-8';
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-16">
		<?php if ( $eyebrow || $heading || $intro ) : ?>
			<div class="flex w-full max-w-[50rem] flex-col items-start gap-4">
				<?php if ( $eyebrow ) : ?>
					<p class="m-0 font-display text-body uppercase tracking-[1px] text-accent">
						<?php echo esc_html( $eyebrow ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $heading ) : ?>
					<h2 class="m-0 font-display text-headline leading-[1.2] text-blue">
						<?php echo esc_html( $heading ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $intro ) : ?>
					<p class="m-0 font-sans text-body leading-[1.2] text-muted">
						<?php echo esc_html( $intro ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) ) : ?>
			<ul class="<?php echo esc_attr( $list_class ); ?>">
				<?php foreach ( $cards as $index => $card ) : ?>
					<?php
					$title  = isset( $card['title'] ) ? $card['title'] : '';
					$points = isset( $card['points'] ) && is_array( $card['points'] ) ? $card['points'] : array();

					if ( ! $title && empty( $points ) ) {
						continue;
					}

					if ( $use_grid ) {
						$card_class = 'flex min-w-0 flex-col items-start gap-6 rounded-card border border-solid border-[#dfe8ff] bg-off-white p-8 lg:gap-8';
					} else {
						// Middle card (2nd) is slightly larger on desktop, matching Figma hierarchy.
						$is_middle  = ( 1 === (int) $index );
						$card_class = $is_middle
							? 'flex min-w-0 flex-1 flex-col items-start gap-8 rounded-card border border-solid border-[#dfe8ff] bg-off-white p-10 lg:flex-[1.15] lg:gap-8 lg:p-12 lg:shadow-sm'
							: 'flex min-w-0 flex-1 flex-col items-start gap-6 rounded-card border border-solid border-[#dfe8ff] bg-off-white p-8 lg:gap-8 lg:p-8';
					}
					?>
					<li class="<?php echo esc_attr( $card_class ); ?>">
						<?php if ( $title ) : ?>
							<h3 class="m-0 font-display text-card-title leading-none text-blue">
								<?php echo esc_html( $title ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( ! empty( $points ) ) : ?>
							<ul class="m-0 flex w-full list-none flex-col items-start gap-4 p-0 pl-4">
								<?php foreach ( $points as $point ) : ?>
									<?php
									$label = isset( $point['label'] ) ? $point['label'] : '';
									if ( ! $label ) {
										continue;
									}
									?>
									<li class="font-sans text-[15px] leading-normal text-muted">
										<?php echo esc_html( $label ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
