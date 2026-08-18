<?php
/**
 * Layout: the_evolution
 *
 * Eyebrow + heading, then three cards with title + point lists.
 * Desktop: 3 columns. Mobile: stacked.
 *
 * Figma desktop: 634:20018 (no mobile frame — stacked adaptation)
 */

$eyebrow = get_sub_field( 'eyebrow' );
$heading = get_sub_field( 'heading' );
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
?>

<section class="bg-white px-10 py-[100px] lg:px-[6.25rem]">
	<div class="mx-auto flex w-full max-w-site flex-col items-start gap-16">
		<?php if ( $eyebrow || $heading ) : ?>
			<div class="flex w-full flex-col items-start gap-4">
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
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) ) : ?>
			<ul class="m-0 grid w-full list-none grid-cols-1 gap-8 p-0 lg:grid-cols-3">
				<?php foreach ( $cards as $card ) : ?>
					<?php
					$title  = isset( $card['title'] ) ? $card['title'] : '';
					$points = isset( $card['points'] ) && is_array( $card['points'] ) ? $card['points'] : array();

					if ( ! $title && empty( $points ) ) {
						continue;
					}
					?>
					<li class="flex flex-col items-start gap-6 rounded-card border border-solid border-[#dfe8ff] bg-off-white p-8 lg:gap-8 lg:p-10">
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
